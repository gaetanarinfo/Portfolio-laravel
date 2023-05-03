<?php

namespace App\Http\Controllers;

use Validator;
use App\Mail\Cart;
use App\Mail\Order;
use App\Models\Event;
use App\Models\Orders;
use App\Mail\OrderError;
use App\Models\Products;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductsContacts;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Srmklive\PayPal\Services\PayPal as PaypalClient;

class CartController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return view
     */
    public function getOffers(Request $request)
    {
        return view('offers');
    }

    /**
     * Create a new controller instance.
     *
     * @return view
     */
    public function getCartSteps(Request $request)
    {

        $products = Products::orderBy('product_id', 'ASC')->get();
        $domain = Cookie::queue('max_domain', "1", 1440);

        if (!empty($_COOKIE['product_formule'])) {
            $product = Products::where('product_id', $_COOKIE['product_formule'])->orderBy('product_id', 'ASC')->first();

            if (!empty($product)) {
                $domain = Cookie::queue('max_domain', $product->max_domain, 1440);
                $max_domain = request()->cookie($domain);
            } else {
                $max_domain = 0;
            }

            $paiement_status = request()->cookie('paiement_status');

            return view('cart', compact('products', 'product', 'max_domain', 'paiement_status'));
        } else {
            return view('offers', compact('products'));
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return json
     */
    public function contactCreate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lastname' => 'bail|required',
            'firstname' => 'bail|required',
            'phone' => 'bail|required',
            'content' => 'bail|required',
            'email' => 'bail|required|email',
            'appointment' => 'bail|required',
            'appointmentTel' => 'bail|required'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'title' => 'Formulaire de contact', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $productCreate = ProductsContacts::create([
                'product_id' => $request->productId,
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'email' => $request->email,
                'appointment' => $request->appointment,
                'appointmentTel' => $request->appointmentTel,
                'phone' => $request->phone,
                'content' => $request->content,
                'domains' => $request->domains
            ]);

            $productCreate->save();

            if (!empty($request->file_0)) {

                $validator = Validator::make($request->all(), [
                    'file' => 'mimes:pdf'
                ]);

                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'Le document doit être au format pdf !', 'title' => 'Ajout de votre maquette !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                } else {
                    $fileName = strtolower($request->lastname . '_' . $request->firstname) . '_' . time() . '.' . $request->file_0->extension();

                    $request->file_0->move(public_path('documents/maquettes'), $fileName);

                    ProductsContacts::where('id', $productCreate->id)
                        ->update(array(
                            'maquette' => $fileName,
                        ));
                }
            }

            Cookie::queue('contact_id', $productCreate->id, 1440);

            $product = Products::where('product_id', $request->productId)
                ->first();

            Mail::to($request->email)
                ->send(new Cart($request->except('_token'), $product, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre demande de devis du ' . date('d/m/Y à H:i')));

            return response()->json(['status' => 1, 'msg' => 'Votre demande de contact nous a été transmise, vous pouvez continuer le processus de votre devis !', 'title' => 'Formulaire de contact', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
        }
    }

    public function handlePayment(Request $request)
    {

        $contact_id = request()->cookie('contact_id');

        $contact = ProductsContacts::where('id', $contact_id)->first();

        $product = Products::where('product_id', $contact->product_id)->first();

        $provider = new PaypalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success.payment'),
                "cancel_url" => route('cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => number_format($product->product_price, 2, '.', '')
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
                ->route('cancel.payment')
                ->with('error', 'Quelque chose s\'est mal passé.');
        } else {

            return redirect()
                ->route('cart')
                ->with('error', $response['message'] ?? 'Quelque chose s\'est mal passé.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('cart')
            ->with('error', $response['message'] ?? 'Vous avez annulé la transaction.');
    }

    public function paymentSuccess(Request $request)
    {

        $provider = new PaypalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $contact_id = request()->cookie('contact_id');

            $contact = ProductsContacts::where('id', $contact_id)->first();

            $product = Products::where('product_id', $contact->product_id)->first();

            $order = Orders::create(array(
                'product_id' => $product->product_id,
                'contact_id' => $contact_id,
                'status' => $response['status'],
                'order_at' => date('Y-m-d H:i:s'),
                'order_method' => "Paypal",
                'transaction_id' => $response['id'],
                'capture_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'price' => $product->product_price
            ));

            $order->save();

            Event::create([
                'product_id' => $product->product_id,
                'title' => 'Rendez-vous avec ' . $contact->lastname . ' ' . $contact->firstname . ' id : ' . $contact->id,
                'start' => $contact->appointment,
                'end' => $contact->appointment,
            ]);

            Event::create([
                'product_id' => $product->product_id,
                'title' => 'Rendez-vous avec ' . $contact->lastname . ' ' . $contact->firstname . ' id : ' . $contact->id,
                'start' => $contact->appointmentTel,
                'end' => $contact->appointmentTel,
            ]);

            $paiement = Cookie::queue('paiement_status', 1, 1440);
            $paiement_status = request()->cookie($paiement);

            $orders = Orders::where('id', $order->id)->first();

            Mail::to($contact->email)
                ->send(new Order($orders, $product, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre paiement n°' . $orders->transaction_id . ' a été accepter'));

            return redirect()->route('cart', compact('paiement_status'));
        } else {

            $contact_id = request()->cookie('contact_id');

            $contact = ProductsContacts::where('id', $contact_id)->first();

            $product = Products::where('product_id', $contact->product_id)->first();

            $order = Orders::create(array(
                'product_id' => $product->product_id,
                'contact_id' => $contact_id,
                'status' => "PAYMENT_DECLINED",
                'order_at' => date('Y-m-d H:i:s'),
                'order_method' => "Paypal",
                'transaction_id' => "",
                'price' => $product->product_price
            ));

            $order->save();

            $paiement = Cookie::queue('paiement_status', 2, 1440);
            $paiement_status = request()->cookie($paiement);

            $orders = Orders::where('id', $order->id)->first();

            Mail::to($contact->email)
                ->send(new OrderError($orders, $product, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre paiement a été refusé'));

            return redirect()->route('cart', compact('paiement_status'))->with('error', $response['message'] ?? 'Votre paiement n\'a pas été accepté.');
        }
    }
}
