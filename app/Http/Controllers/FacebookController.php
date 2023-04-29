<?php

namespace App\Http\Controllers;

use File;
use Exception;
use App\Models\User;
use App\Functions\Log;
use App\Mail\Register;
use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback(Request $request, int $year = null)
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('facebook_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user('Connexion utilisateur', 'Une connexion a été détecté sur votre compte !', url()->current(), $request->ip());

                $fileContents = file_get_contents($user->avatar);
                $avatarName = File::put(public_path('img/profil/') . $user->getId() . ".jpg", $fileContents);

                User::where('email', $user->email)
                    ->update([
                        'name' => $user->name,
                        'facebook_id' => $user->id,
                        'avatar' => $user->getId() . ".jpg",
                    ]);

                User::where('email', $user->email)
                    ->update([
                        'logged_at' => date('Y-m-d H:i:s')
                    ]);

                $user = User::where('active', 1)
                    ->where('id', Auth::id())
                    ->first();

                $contacts = Contact::where('archive', 0)
                    ->join('users', 'users.email', '=', 'contacts.email')
                    ->where('contacts.to_mail', $user->email)
                    ->orderBy('contacts.created_at', 'DESC')
                    ->limit(6)
                    ->get();

                if ($user->admin == 1) {

                    $months = DB::table('months')->get();

                    // Données du graph de total
                    $commandes_graph = array();
                    $commandes_refund_graph = array();

                    foreach ($months as $month) {

                        if (empty($year)) {
                            $start_date_graph = date('Y') . "-" . $month->id . "-01";
                            $end_date_graph = date('Y') . "-" . $month->id . "-30";
                        } else {
                            $start_date_graph = $year . "-" . $month->id . "-01";
                            $end_date_graph = $year . "-" . $month->id . "-30";
                        }

                        $from = $start_date_graph;
                        $to = $end_date_graph;

                        $commande_chiffres = DB::table('google_play_orders')
                            ->select(DB::raw("COUNT(Item_Price) as total"))
                            ->where('Financial_Status', 'Charged')
                            ->whereBetween('Order_Charged_Date', [$from, $to])
                            ->first();

                        $commande_chiffres_refund = DB::table('google_play_orders')
                            ->select(DB::raw("COUNT(Item_Price) as total"))
                            ->where('Financial_Status', 'Refund')
                            ->whereBetween('Order_Charged_Date', [$from, $to])
                            ->first();

                        if ($commande_chiffres->total == "") $commandes_graph[] = '0';
                        else $commandes_graph[] = $commande_chiffres->total;

                        if ($commande_chiffres_refund->total == "") $commandes_graph_refund[] = '0';
                        else $commandes_graph_refund[] = $commande_chiffres_refund->total;
                    }

                    $commandes_graph = implode(',', $commandes_graph);
                    $commandes_graph_refund = implode(',', $commandes_graph_refund);

                    $total_commandes = DB::table('google_play_orders')
                        ->where('Financial_Status', 'Charged')
                        ->sum('Item_Price');

                    $totals_commandes = DB::table('google_play_orders')
                        ->orderBy('Order_Charged_Date', 'DESC')
                        ->get();

                    $total_commandes_refund = DB::table('google_play_orders')
                        ->where('Financial_Status', 'Refund')
                        ->sum('Item_Price');

                    return redirect()->route('dashboard')->with('user', 'commandes_graph', 'commandes_graph_refund', 'year', 'total_commandes', 'totals_commandes', 'total_commandes_refund', 'contacts');
                } else {
                    return redirect()->route('dashboard')->with('user', 'contacts');
                }
            } else {

                $fileContents = file_get_contents($user->getAvatar());
                $avatarName = File::put(public_path('img/profil/') . $user->getId() . ".jpg", $fileContents);

                $password = Hash::make(Str::random(10));
                $token = md5(rand(1, 10) . microtime());

                $newUser = User::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'password' => $password,
                    'email' => $user->email,
                    'avatar' => $user->getId() . ".jpg",
                    'token' => $token,
                    'facebook_id' => $user->id
                ]);

                Mail::to($user->email)
                    ->send(new Register(array('name' => $user->name, 'firstname' => "", 'email' => $user->email, 'password' => $password, 'token' => $token), 'contact@portfolio-gaetan.fr', 'Portefolio', 'Inscription sur mon portfolio'));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user('Création de votre compte', 'Votre compte a bien été créer sur mon site internet !', url()->current(), $request->ip());

                Auth::login($newUser);

                User::where('email', $user->email)
                    ->update([
                        'logged_at' => date('Y-m-d H:i:s')
                    ]);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user('Connexion utilisateur', 'Une connexion a été détecté sur votre compte !', url()->current(), $request->ip());

                $user = User::where('active', 1)
                    ->where('id', Auth::id())
                    ->first();

                $contacts = Contact::where('archive', 0)
                    ->join('users', 'users.email', '=', 'contacts.email')
                    ->where('contacts.to_mail', $user->email)
                    ->orderBy('contacts.created_at', 'DESC')
                    ->limit(6)
                    ->get();

                if ($user->admin == 1) {

                    $months = DB::table('months')->get();

                    // Données du graph de total
                    $commandes_graph = array();
                    $commandes_refund_graph = array();

                    foreach ($months as $month) {

                        if (empty($year)) {
                            $start_date_graph = date('Y') . "-" . $month->id . "-01";
                            $end_date_graph = date('Y') . "-" . $month->id . "-30";
                        } else {
                            $start_date_graph = $year . "-" . $month->id . "-01";
                            $end_date_graph = $year . "-" . $month->id . "-30";
                        }

                        $from = $start_date_graph;
                        $to = $end_date_graph;

                        $commande_chiffres = DB::table('google_play_orders')
                            ->select(DB::raw("COUNT(Item_Price) as total"))
                            ->where('Financial_Status', 'Charged')
                            ->whereBetween('Order_Charged_Date', [$from, $to])
                            ->first();

                        $commande_chiffres_refund = DB::table('google_play_orders')
                            ->select(DB::raw("COUNT(Item_Price) as total"))
                            ->where('Financial_Status', 'Refund')
                            ->whereBetween('Order_Charged_Date', [$from, $to])
                            ->first();

                        if ($commande_chiffres->total == "") $commandes_graph[] = '0';
                        else $commandes_graph[] = $commande_chiffres->total;

                        if ($commande_chiffres_refund->total == "") $commandes_graph_refund[] = '0';
                        else $commandes_graph_refund[] = $commande_chiffres_refund->total;
                    }

                    $commandes_graph = implode(',', $commandes_graph);
                    $commandes_graph_refund = implode(',', $commandes_graph_refund);

                    $total_commandes = DB::table('google_play_orders')
                        ->where('Financial_Status', 'Charged')
                        ->sum('Item_Price');

                    $totals_commandes = DB::table('google_play_orders')
                        ->orderBy('Order_Charged_Date', 'DESC')
                        ->get();

                    $total_commandes_refund = DB::table('google_play_orders')
                        ->where('Financial_Status', 'Refund')
                        ->sum('Item_Price');

                    return redirect()->route('dashboard')->with('user', 'commandes_graph', 'commandes_graph_refund', 'year', 'total_commandes', 'totals_commandes', 'total_commandes_refund', 'contacts');
                } else {
                    return redirect()->route('dashboard')->with('user', 'contacts');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
