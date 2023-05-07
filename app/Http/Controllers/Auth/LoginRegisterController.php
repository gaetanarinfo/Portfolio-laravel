<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\Pays;
use App\Models\User;
use App\Functions\Log;
use App\Models\Contact;
use App\Mail\RegisterMail;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TopicsReplies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginRegisterController extends Controller
{

    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a notifications.
     *
     */
    public static function Notif()
    {
        $notifications = [];

        // Notification des message non vérifié sur le forums
        $forum_topic_replies = TopicsReplies::where('topics_replies.status', 0)
            ->where('topics_replies.archive_dashboard', 0)
            ->join('users', 'users.id', '=', 'topics_replies.user_id')
            ->select('topics_replies.*', 'users.lastname', 'users.firstname', 'users.avatar')
            ->get();

        if (!empty($forum_topic_replies) && count($forum_topic_replies) >= 1) {
            array_push($notifications, array('forums_replies' => $forum_topic_replies));
        }
        // ------------ //

        return $notifications;
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lastname' => 'bail|required',
            'firstname' => 'bail|required',
            'civilite' => 'bail|required',
            'pseudo' => 'bail|required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:8',
            'password_confirmation' => 'bail|required|min:8',
        ]);

        $error = [];

        if (empty($request->lastname)) {
            $error['lastname'] = array('Le champ nom est obligatoire.');
        }

        if (empty($request->firstname)) {
            $error['firstname'] = array('Le champ prénom est obligatoire.');
        }

        if (empty($request->civilite)) {
            $error['civilite'] = array('Le champ civilité est obligatoire.');
        }

        if (empty($request->naissance)) {
            $error['naissance'] = array('Le champ date de naissance est obligatoire.');
        }

        if (empty($request->pseudo)) {
            $error['pseudo'] = array('Le champ pseudo est obligatoire.');
        }

        if (empty($request->email)) {
            $error['email'] = array('Le champ email est obligatoire.');
        } else {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = array('Le champ email doit être une adresse email valide.');
            }
        }

        if (empty($request->password)) {
            $error['password'] = array('Le champ mot de passe est obligatoire.');
        }

        if (mb_strlen($request->password) < 7) {
            $error['password'] = array('Votre mot de passe doit comporter plus de 8 caractères');
        }

        if (empty($request->passwordconfirmation)) {
            $error['passwordconfirmation'] = array('Le champ confirmation du mot de passe est obligatoire.');
        }

        if ($request->password != $request->passwordconfirmation) {
            $error['passwordconfirmation'] = array('Les mot de passe ne correspond pas.');
        }

        if (!$validator->passes() && $request->password != $request->passwordconfirmation or mb_strlen($request->password) < 7) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Création de votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $user = DB::table('users')
                ->where('email', $request->email)
                ->get();

            if (count($user) <= 0) {

                User::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'civilite' => $request->civilite,
                    'naissance' => $request->naissance,
                    'pseudo' => $request->pseudo,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                $credentials = $request->only('email', 'password');

                Auth::attempt($credentials);

                $request->session()->regenerate();

                DB::table('users')
                    ->where('email', $request->email)
                    ->update([
                        'logged_at' => date('Y/m/d H:i:s'),
                        'token' => $request->token
                    ]);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Création de votre compte', 'Votre compte a bien été créer sur mon site internet !', url()->current(), $request->ip());

                Mail::to($request->email)
                    ->send(new RegisterMail($request->except('_token'), 'contact@portfolio-gaetan.fr', 'Portefolio', 'Inscription sur mon portfolio'));

                return response()->json(['status' => 1, 'msg' => 'Vous vous êtes inscrit et connecté avec succès !', 'title' => 'Céation de votre compte !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Vous possedez déjà un compte avec ' . $request->email . ' !', 'title' => 'Céation de votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'bail|required'
        ]);

        $error = [];

        if (empty($request->email)) {
            $error['email'] = array('Le champ email est obligatoire.');
        } else {
            if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = array('Le champ email doit être une adresse email valide.');
            }
        }

        if (empty($request->password)) {
            $error['password'] = array('Le champ mot de passe est obligatoire.');
        }

        if (!$validator->passes()) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Connexion à votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (Auth::attempt($credentials)) {

                $request->session()->regenerate();

                DB::table('users')
                    ->where('email', $request->email)
                    ->update([
                        'logged_at' => date('Y-m-d H:i:s')
                    ]);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Connexion utilisateur', 'Une connexion a été détecté sur votre compte !', url()->current(), $request->ip());

                return response()->json(['status' => 1, 'msg' => 'Connexion réussi vous allez être redirigée dans quelque instant.', 'title' => 'Connexion à votre compte !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Votre compte n\'existe pas dans notre base ! <a href="/register">Cliquer-ici</a> pour en créer un.', 'title' => 'Connexion à votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(int $year = null)
    {

        if (Auth::check()) {

            $pays = Pays::orderBy('id', 'ASC')->get();

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->first();

            $contacts = Contact::where('archive', 0)
                ->join('users', 'users.email', '=', 'contacts.email')
                ->where('contacts.to_mail', $user->email)
                ->orderBy('contacts.created_at', 'DESC')
                ->limit(6)
                ->get();

            $notifications = $this->Notif();

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


                return view('auth.dashboard', compact('user', 'commandes_graph', 'commandes_graph_refund', 'year', 'total_commandes', 'totals_commandes', 'total_commandes_refund', 'contacts', 'pays', 'notifications'));
            } else {
                return view('auth.dashboard', compact('user', 'contacts', 'pays', 'notifications'));
            }
        }

        return redirect()->route('login');
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        // Logs
        $logs_user = new Log();
        $logs_user->log_user(Auth::id(), 'Déconnexion utilisateur', 'Votre compte a été déconnecté !', url()->current(), $request->ip());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Session::flush();
        return redirect()->route('home');
    }

    /**
     * Reinitialisation password the user from application.
     *
     * @param  Token $token
     * @return \Illuminate\Http\Response
     */
    public function forgot_password($token)
    {
        $verfication_token = User::where('token', $token)
            ->first();

        if (!empty($verfication_token->email)) {
            return view('forgotPassword')->with('token', $token);
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Reinitialisation password the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgot_password_change(Request $request)
    {

        if (empty($request->password) == true) {
            $error['password'] = array('Le champ mot de passe est obligatoire.');
        }

        if (empty($request->passwordconfirmation) == true) {
            $error['passwordconfirmation'] = array('Le champ confirmation du mot de passe est obligatoire.');
        }

        if ($request->password != $request->passwordconfirmation) {
            $error['passwordconfirmation'] = array('Les mot de passe ne correspond pas.');
        }

        if (empty($request->password) == true && empty($request->passwordconfirmation) == true or $request->password != $request->passwordconfirmation) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $verfication_token = User::where('token', $request->token)
                ->first();

            if (!empty($verfication_token->email)) {

                DB::table('users')
                    ->where('token', $request->token)
                    ->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => date('Y/m/d H:i:s'),
                        'token' => ''
                    ]);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user($verfication_token->id, 'Mot de passe modifiée', 'Une demande de nouveau mot de passe a été demandé !', url()->current(), $request->ip());

                return response()->json(['status' => 1, 'msg' => 'Votre mot de passe a été modifiée avec succès !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Il semble y avoir un problème avec le token, merci de recommencer l\'opération ultérieurement !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    public function forgot_password_new(Request $request)
    {

        if (empty($request->emailForgot)) {
            $error['email'] = array('Le champ email est obligatoire.');
        } else {
            if (!filter_var($request->emailForgot, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = array('Le champ email doit être une adresse email valide.');
            }
        }

        if (empty($request->emailForgot)) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else if (!filter_var($request->emailForgot, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $verfication_email = User::where('email', $request->emailForgot)
                ->first();

            if (!empty($verfication_email->email)) {

                DB::table('users')
                    ->where('email', $request->emailForgot)
                    ->update([
                        'token' => $request->tokens,
                        'updated_at' => date('Y/m/d H:i:s')
                    ]);

                // Logs
                $logs_user = new Log();
                $logs_user->log_user($verfication_email->id, 'Mot de passe modifiée', 'Une demande de nouveau mot de passe a été demandé !', url()->current(), $request->ip());

                Mail::to($request->emailForgot)
                    ->send(new ForgotPassword($request->except('_token'), 'contact@portfolio-gaetan.fr', 'Portefolio', 'Modification de votre mot de passe sur mon portfolio'));

                return response()->json(['status' => 1, 'msg' => 'Un email vous à été envoyé avec le lien de réinitialisation !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Il semble y avoir un problème avec le formulaire, merci de recommencer l\'opération ultérieurement !', 'title' => 'Modification de votre mot de passe !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }
}
