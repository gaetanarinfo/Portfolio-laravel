<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'bail|required|email',
            'password' => 'bail|required',
            'password_confirmation' => 'bail|required',
        ]);

        $error = [];

        if (empty($request->lastname)) {
            $error['lastname'] = array('Le champ nom est obligatoire.');
        }

        if (empty($request->firstname)) {
            $error['firstname'] = array('Le champ prénom est obligatoire.');
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

        if (empty($request->passwordconfirmation)) {
            $error['passwordconfirmation'] = array('Le champ confirmation du mot de passe est obligatoire.');
        }

        if ($request->password != $request->passwordconfirmation) {
            $error['passwordconfirmation'] = array('Les mot de passe ne correspond pas.');
        }

        if (!$validator->passes() && $request->password != $request->passwordconfirmation) {
            return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Création de votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $user = DB::table('users')
                ->where('email', $request->email)
                ->get();

            if (count($user) <= 1) {

                User::create([
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                error_reporting(E_ALL);
                ini_set("display_errors", 1);

                $credentials = $request->only('email', 'password');

                Auth::attempt($credentials);

                $request->session()->regenerate();

                DB::table('users')
                    ->where('email', $request->email)
                    ->update([
                        'logged_at' => date('Y/m/d H:i:s')
                    ]);

                return response()->json(['status' => 1, 'msg' => 'Vous vous êtes inscrit et connecté avec succès !', 'title' => 'Céation de votre compte !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {

                $credentials = $request->only('email', 'password');

                Auth::attempt($credentials);

                $request->session()->regenerate();

                DB::table('users')
                    ->where('email', $request->email)
                    ->update([
                        'logged_at' => date('Y/m/d H:i:s')
                    ]);

                return response()->json(['status' => 1, 'msg' => 'Vous possedez déjà un compte avec ' . $request->email . '!', 'title' => 'Céation de votre compte !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
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
                        'logged_at' => date('Y/m/d H:i:s')
                    ]);

                return response()->json(['status' => 1, 'msg' => 'Connexion réussi vous allez être redirigée dans quelque instant.', 'title' => 'Connexion à votre compte !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Connexion à votre compte !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
