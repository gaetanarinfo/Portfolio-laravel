<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Mail\OrderApps;
use App\Models\Projets;
use Illuminate\View\View;
use App\Models\OrdersApps;
use App\Models\ProjetsAvis;
use App\Mail\OrderAppsError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PaypalClient;

class ApplicationsController extends Controller
{

    public function getSingleApps($url = null)
    {

        if ($url !== null) {

            $projet = Projets::where('projets.url', $url)
                ->where('projets.categorie', 'android')
                ->leftJoin('projets_avis', 'projets_avis.projets_id', '=', 'projets.id')
                ->select('projets.*', DB::raw("COUNT(projets_avis.id) as counter_avis"))
                ->groupBy('projets.id')
                ->first();

            if ($projet) {

                $projet_id = Projets::where('url', $url)
                    ->where('categorie', 'android')
                    ->select('id')
                    ->first();

                $user = User::where('active', 1)
                    ->where('id', Auth::id())
                    ->first();

                $user_verif_projet = ProjetsAvis::where('user_id', Auth::id())
                    ->where('projets_id', $projet->id)
                    ->first();

                $sum_avis = ProjetsAvis::where('projets_id', $projet->id)
                    ->sum('note');

                $projets = Projets::where('projets.url', '!=', $url)
                    ->where('projets.categorie', 'android')
                    ->where('projets.active', 1)
                    ->leftJoin('projets_avis', 'projets_avis.projets_id', '=', 'projets.id')
                    ->select('projets.*', DB::raw("COUNT(projets_avis.id) as counter_avis"))
                    ->groupBy('projets.id')
                    ->orderByDesc('projets.id')
                    ->limit(6)
                    ->get();

                $avis = ProjetsAvis::where('projets_id', $projet->id)
                    ->join('users', 'users.id', '=', 'projets_avis.user_id')
                    ->where('projets_avis.active', 1)
                    ->orderByDesc('projets_avis.created_at')
                    ->get();

                $orders_apps = OrdersApps::where('user_id', Auth::id())
                    ->where('projets_id', $projet->id)
                    ->where('status', 'COMPLETED')
                    ->get();

                return view('application', compact('projet', 'projet_id', 'projets', 'user', 'user_verif_projet', 'sum_avis', 'avis', 'orders_apps'));
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('home');
        }
    }

    public function postCommentSingleApps(Request $request, $url = null)
    {

        if (Auth::check()) {

            $validator = Validator::make($request->all(), [
                'noteComments' => 'bail|required',
                'appsComment' => 'bail|required'
            ]);

            if (!$validator->passes()) {

                return response()->json(['status' => 0, 'title' => 'Avis sur application', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                $projet = Projets::where('id', $request->idProjets)
                    ->where('projets.categorie', 'android')
                    ->where('active', '1')
                    ->first();

                ProjetsAvis::create([
                    'projets_id' => $request->idProjets,
                    'user_id' => Auth::id(),
                    'note' => $request->noteComments,
                    'comment' => $request->appsComment
                ]);

                return response()->json(['status' => 1, 'msg' => 'Merci pour votre avis, il a bien été posté.', 'title' => 'Avis sur application', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'title' => 'Avis sur application', 'toast' => 'toast-error', 'msg' => 'Vous devez être connecté pour faire celà !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    public function handlePaymentApps(Request $request, $projet_id = null)
    {

        $projet = Projets::where('id', $projet_id)->first();

        $provider = new PaypalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment.apps', $projet->url),
                "cancel_url" => route('cancel.payment.apps', $projet->url),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => number_format($projet->prix, 2, '.', '')
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('cancel.payment.apps', $projet->url)
                ->with('error', 'Quelque chose s\'est mal passé.');
        } else {

            return redirect()
                ->route('application', $projet->url)
                ->with('error', $response['message'] ?? 'Quelque chose s\'est mal passé.');
        }
    }

    public function paymentSuccessApps(Request $request, $url = null)
    {

        $provider = new PaypalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $projet = Projets::where('url', $url)->first();

            $user = User::where('id', Auth::id())->first();

            $order = OrdersApps::create(array(
                'projets_id' => $projet->id,
                'user_id' => Auth::id(),
                'status' => $response['status'],
                'order_at' => date('Y-m-d H:i:s'),
                'order_method' => "Paypal",
                'transaction_id' => $response['id'],
                'capture_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'price' => $projet->prix
            ));

            $order->save();

            $orders = OrdersApps::where('id', $order->id)->first();

            Projets::where('id', $projet->id)
                ->update(array(
                    'audience' => $projet->audience + 1,
                    'revenu_brut' => $projet->revenu_brut + $projet->prix
                ));

            Mail::to($user->email)
                ->send(new OrderApps($orders, $projet, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre paiement n°' . $orders->transaction_id . ' a été accepter'));

            return redirect()
                ->route('application', $url)
                ->with('success', $response['message'] ?? 'Merci, votre paiement a été accepté. Merci de vous rendre sur votre espace.');
        } else {

            $projet = Projets::where('url', $url)->first();

            $user = User::where('id', Auth::id())->first();

            $order = OrdersApps::create(array(
                'projets_id' => $projet->id,
                'user_id' => Auth::id(),
                'status' => "PAYMENT_DECLINED",
                'order_at' => date('Y-m-d H:i:s'),
                'order_method' => "Paypal",
                'transaction_id' => "",
                'price' => $projet->prix
            ));

            $order->save();

            $orders = OrdersApps::where('id', $order->id)->first();

            Mail::to($user->email)
                ->send(new OrderAppsError($orders, $projet, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre paiement a été refusé'));

            return redirect()
                ->route('application', $url)
                ->with('error', $response['message'] ?? 'Votre paiement n\'a pas été accepté.');
        }
    }

    public function paymentCancelApps($url = null)
    {
        return redirect()
            ->route('application', $url)
            ->with('error', $response['message'] ?? 'Vous avez annulé la transaction.');
    }
}
