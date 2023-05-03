<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\News;
use App\Models\User;
use App\Functions\Log;
use App\Models\Orders;
use App\Models\Contact;
use App\Models\Projets;
use App\Models\Products;
use App\Mail\OrderRefund;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductsContacts;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PaypalClient;

class UsersController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    public function __construct()
    {

        $this->middleware('auth')->except([
            'logout', 'dashboard'
        ]);
    }

    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_users()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $users = User::orderBy('created_at', 'DESC')
                ->get();

            $users_banned = User::where('active', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            $users_active = User::where('active', 1)
                ->orderBy('created_at', 'DESC')
                ->get();

            if (isset($user)) {
                return view('auth.admin.show_users', compact('user', 'users', 'users_active', 'users_banned', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_users', compact('user', 'users', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Delete user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_user(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $user_delete = User::where('id', $request->user_id)->first();
            if (!empty($user_delete->image) && $user_delete->image != "default.svg") {
                $file_path = app_path() . '/../public/img/profil/' . $user_delete->avatar;
                unlink($file_path);
            }

            User::where('id', $request->user_id)->delete();

            // Logs
            $logs_user = new Log();
            $logs_user->log_user(Auth::id(), 'Utilisateur', 'Un utilisateur a été supprimer !', url()->current(), $request->ip());

            return response()->json(['status' => 1, 'msg' => 'L\'utilisateur a été supprimé.', 'title' => 'Supprimer un utilisateur', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Supprimer un utilisateur', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Edit user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_user(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $validator = Validator::make($request->all(), [
                'email' => 'bail|required|email',
                'lastname' => 'bail|required',
                'firstname' => 'bail|required',
                'active' => 'bail|required'
            ]);

            $error = [];

            if (empty($request->email)) {
                $error['email'] = array('Le champ email est obligatoire.');
            } else {
                if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $error['email'] = array('Le champ email doit être une adresse email valide.');
                }
            }

            if (empty($request->lastname)) {
                $error['lastname'] = array('Le champ nom est obligatoire.');
            }

            if (empty($request->firstname)) {
                $error['firstname'] = array('Le champ prénom est obligatoire.');
            }

            if (empty($request->active)) {
                $error['active'] = array('Le champ active est obligatoire.');
            }

            if (!$validator->passes()) {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'title' => 'Modification d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'avatar doit être au format image !', 'title' => 'Modification d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($request->lastname . '_' . $request->firstname) . '_' . time() . '.' . $request->file_0->extension();

                        $request->file_0->move(public_path('img/profil'), $fileName);

                        User::where('id', $request->user_id)
                            ->update(array(
                                'avatar' => $fileName,
                            ));
                    }
                }

                User::where('id', $request->user_id)
                    ->update(array(
                        'lastname' => $request->lastname,
                        'firstname' => $request->firstname,
                        'email' => $request->email,
                        'active' => $request->active,
                        'updated_at' => date('Y/m/d H:i:s')
                    ));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Utilisateur', 'Un utilisateur a été modifiée !', url()->current(), $request->ip());

                return response()->json(['status' => 1, 'msg' => 'L\'utilisateur a été modifiée.', 'title' => 'Modification d\'un utilisateur', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Modification d\'un utilisateur', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Add user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_user(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $validator = Validator::make($request->all(), [
                'email' => 'bail|required|email',
                'password' => 'bail|required',
                'lastname' => 'bail|required',
                'firstname' => 'bail|required',
                'active' => 'bail|required'
            ]);

            $error = [];

            if (empty($request->email)) {
                $error['email'] = array('Le champ email est obligatoire.');
            } else {
                if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $error['email'] = array('Le champ email doit être une adresse email valide.');
                }
            }

            if (mb_strlen($request->password) < 7) {
                $error['password'] = array('Votre mot de passe doit comporter plus de 8 caractères');
            }

            if (empty($request->lastname)) {
                $error['lastname'] = array('Le champ nom est obligatoire.');
            }

            if (empty($request->firstname)) {
                $error['firstname'] = array('Le champ prénom est obligatoire.');
            }

            if (empty($request->active)) {
                $error['active'] = array('Le champ active est obligatoire.');
            }

            if (!$validator->passes() && $request->password != $request->passwordconfirmation or mb_strlen($request->password) < 7) {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'title' => 'Création d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                $insert = User::create(array(
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'active' => $request->active
                ));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Utilisateur', 'Un utilisateur a été créer !', url()->current(), $request->ip());

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'avatar doit être au format image !', 'title' => 'Création d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($request->lastname . '_' . $request->firstname) . '_' . time() . '.' . $request->file_0->extension();

                        $request->file_0->move(public_path('img/profil'), $fileName);

                        $insert->save();

                        User::where('id', $insert->id)
                            ->update(array(
                                'avatar' => $fileName,
                            ));
                    }
                } else {
                    $fileName = '';
                }


                return response()->json(['status' => 1, 'msg' => 'L\'utilisateur a été créer.', 'title' => 'Création d\'un utilisateur', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Création d\'un utilisateur', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Display a dashboard to projets.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_projets()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();


        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $projets = Projets::orderBy('created_at', 'DESC')
                ->get();

            $projets_inactive = Projets::where('active', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            $projets_active = Projets::where('active', 1)
                ->orderBy('created_at', 'DESC')
                ->get();

            if (isset($user)) {
                return view('auth.admin.show_projets', compact('user', 'projets', 'projets_active', 'projets_inactive', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_projets', compact('user', 'projets', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Delete projet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_projet(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $projet_delete = Projets::where('id', $request->projet_id)->first();

            if (!empty($projet_delete->image) && $projet_delete->image != "default.png") {
                $file_path = app_path() . '/../public/img/projets/' . $projet_delete->image;
                unlink($file_path);
            }

            Projets::where('id', $request->projet_id)->delete();

            // Logs
            $logs_user = new Log();
            $logs_user->log_user(Auth::id(), 'Projet', 'Un projet a été supprimer !', url()->current(), $request->ip());

            return response()->json(['status' => 1, 'msg' => 'Le projet a été supprimé.', 'title' => 'Supprimer un projet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Supprimer un projet', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Edit projet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_projet(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $validator = Validator::make($request->all(), [
                'title' => 'bail|required',
                'categorie' => 'bail|required',
                'url' => 'bail|required',
                'prix' => 'bail|required',
                'active' => 'bail|required'
            ]);

            $error = [];

            if (empty($request->title)) {
                $error['title'] = array('Le champ titre est obligatoire.');
            }

            if (empty($request->url)) {
                $error['url'] = array('Le champ url est obligatoire.');
            }

            if (empty($request->categorie)) {
                $error['categorie'] = array('Le champ catégorie est obligatoire.');
            }

            if (empty($request->prix)) {
                $error['prix'] = array('Le champ prix est obligatoire.');
            }

            if (empty($request->active)) {
                $error['active'] = array('Le champ active est obligatoire.');
            }

            if (!$validator->passes()) {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($user->lastname . '_' . $user->firstname) . '_' . time() . '.' . $request->file_0->extension();

                        $request->file_0->move(public_path('img/projets'), $fileName);

                        Projets::where('id', $request->projet_id)
                            ->update(array(
                                'image' => $fileName,
                            ));
                    }
                }

                Projets::where('id', $request->projet_id)
                    ->update(array(
                        'title' => $request->title,
                        'url' => $request->url,
                        'prix' => str_replace(',', '.', $request->prix),
                        'categorie' => $request->categorie,
                        'active' => $request->active,
                        'updated_at' => date('Y/m/d H:i:s')
                    ));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Projet', 'Un projet a été modifiée !', url()->current(), $request->ip());

                return response()->json(['status' => 1, 'msg' => 'Le projet a été modifiée.', 'title' => 'Modification d\'un projet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Modification d\'un projet', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Add projet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_projet(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $validator = Validator::make($request->all(), [
                'title' => 'bail|required',
                'categorie' => 'bail|required',
                'url' => 'bail|required',
                'prix' => 'bail|required',
                'active' => 'bail|required'
            ]);

            $error = [];

            if (empty($request->title)) {
                $error['title'] = array('Le champ titre est obligatoire.');
            }

            if (empty($request->url)) {
                $error['url'] = array('Le champ url est obligatoire.');
            }

            if (empty($request->categorie)) {
                $error['categorie'] = array('Le champ catégorie est obligatoire.');
            }

            if (empty($request->prix)) {
                $error['prix'] = array('Le champ prix est obligatoire.');
            }

            if (empty($request->active)) {
                $error['active'] = array('Le champ active est obligatoire.');
            }

            if (!$validator->passes()) {
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'title' => 'Création d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                $insert = Projets::create(array(
                    'categorie' => $request->categorie,
                    'title' => $request->title,
                    'url' => $request->url,
                    'prix' => str_replace(',', '.', $request->prix),
                    'active' => $request->active
                ));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Projet', 'Un projet a été créer !', url()->current(), $request->ip());

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Création d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($user->lastname . '_' . $user->firstname) . '_' . time() . '.' . $request->file_0->extension();

                        $request->file_0->move(public_path('img/projets'), $fileName);

                        $insert->save();

                        Projets::where('id', $insert->id)
                            ->update(array(
                                'image' => $fileName,
                            ));
                    }
                } else {
                    $fileName = '';
                }


                return response()->json(['status' => 1, 'msg' => 'Le projet a été créer.', 'title' => 'Création d\'un projet', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            }
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Création d\'un projet', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Display a dashboard to blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_blog()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $blogs = News::orderBy('created_at', 'DESC')
                ->get();

            $articles_inactive = News::where('active', 0)
                ->orderBy('created_at', 'DESC')
                ->get();

            $articles_active = News::where('active', 1)
                ->orderBy('created_at', 'DESC')
                ->get();

            if (isset($user)) {
                return view('auth.admin.show_blog', compact('user', 'blogs', 'articles_active', 'articles_inactive', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_blog', compact('user', 'blogs', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Delete article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_article(Request $request)
    {

        $user = User::where('active', 1)
            ->where('id', Auth::id())
            ->where('admin', 1)
            ->first();

        if (isset($user)) {

            $article_delete = News::where('id', $request->article_id)->first();

            if (!empty($article_delete->image) && $article_delete->image != "picture-empty.jpg") {
                $file_path = app_path() . '/../public/img/news/' . $article_delete->image;
                unlink($file_path);
            }

            if (!empty($article_delete->image_bandeau) && $article_delete->image_bandeau != "picture-empty.jpg") {
                $file_path = app_path() . '/../public/img/news/' . $article_delete->image_bandeau;
                unlink($file_path);
            }

            if (!empty($article_delete->avatar) && $article_delete->avatar != "default.svg") {
                $file_path = app_path() . '/../public/img/news/avatar/' . $article_delete->avatar;
                unlink($file_path);
            }

            News::where('id', $request->article_id)->delete();

            // Logs
            $logs_user = new Log();
            $logs_user->log_user(Auth::id(), 'Blog', 'Un article a été supprimer !', url()->current(), $request->ip());

            return response()->json(['status' => 1, 'msg' => 'L\'article a été supprimé.', 'title' => 'Supprimer un article', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Vous n\'avez pas la permission.', 'title' => 'Supprimer un article', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        }
    }

    /**
     * Display a dashboard to blog and update.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_article($slug)
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $article = News::where('url', $slug)
                ->first();

            if (isset($user) && isset($article)) {
                return view('auth.admin.update_blog', compact('user', 'article', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.update_blog', compact('user', 'article', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Update article.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_article_post(Request $request, $slug)
    {

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $article = News::where('url', $slug)
                ->first();

            if (isset($user) && isset($article)) {

                $validator = Validator::make($request->all(), [
                    'email' => 'bail|required|email',
                    'title' => 'bail|required',
                    'small_content' => 'bail|required',
                    'large_content' => 'bail|required',
                    'categorie' => 'bail|required',
                    'author' => 'bail|required',
                    'author_content' => 'bail|required',
                    'author_link' => 'bail|required',
                    'source' => 'bail|required'
                ]);

                if (!$validator->passes()) {
                    return response()->json(['status' => 0, 'title' => 'Modification de l\'article', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                } else {

                    if (!empty($request->file_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($article->id) . '_' . time() . '.' . $request->file_0->extension();

                            $request->file_0->move(public_path('img/news'), $fileName);

                            News::where('id', $article->id)
                                ->update(array(
                                    'image' => $fileName,
                                ));
                        }
                    }

                    if (!empty($request->files_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($article->id) . '_' . time() . '.' . $request->files_0->extension();

                            $request->files_0->move(public_path('img/news'), $fileName);

                            News::where('id', $article->id)
                                ->update(array(
                                    'image_bandeau' => $fileName,
                                ));
                        }
                    }

                    if (!empty($request->filese_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($article->id) . '_' . time() . '.' . $request->filese_0->extension();

                            $request->filese_0->move(public_path('img/news/avatar'), $fileName);

                            News::where('id', $article->id)
                                ->update(array(
                                    'avatar' => $fileName,
                                ));
                        }
                    }

                    News::where('id', $article->id)
                        ->update(array(
                            'email' => $request->email,
                            'title' => $request->title,
                            'url' => Str::slug($request->title),
                            'small_content' => $request->small_content,
                            'large_content' => $request->large_content,
                            'categorie' => $request->categorie,
                            'author' => $request->author,
                            'author_content' => $request->author_content,
                            'author_link' => $request->author_link,
                            'source' => $request->source,
                            'url_fb' => $request->url_fb,
                            'url_twitter' => $request->url_twitter,
                            'url_linkedin' => $request->url_linkedin,
                            'updated_at' => date('Y/m/d H:i:s')
                        ));

                    // Logs
                    $logs_user = new Log();
                    $logs_user->log_user(Auth::id(), 'Blog', 'Un article a été modifiée !', url()->current(), $request->ip());

                    return response()->json(['status' => 1, 'msg' => 'Votre article a bien été modifiée.', 'title' => 'Modification de l\'article', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
                }
            } else {
                return response()->json(['status' => 0, 'title' => 'Modification de l\'article', 'toast' => 'toast-error', 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display a dashboard to blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_article()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            if (isset($user)) {
                return view('auth.admin.add_blog', compact('user', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.add_blog', compact('user', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Update article.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_article_post(Request $request)
    {

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            if (isset($user)) {

                $validator = Validator::make($request->all(), [
                    'emailAuthor' => 'bail|required|email',
                    'title' => 'bail|required',
                    'small_content' => 'bail|required',
                    'large_content' => 'bail|required',
                    'categorie' => 'bail|required',
                    'author' => 'bail|required',
                    'author_content' => 'bail|required',
                    'author_link' => 'bail|required',
                    'sourceArticle' => 'bail|required'
                ]);

                if (!$validator->passes()) {
                    return response()->json(['status' => 0, 'title' => 'Ajout de l\'article', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                } else {

                    $insert = News::create(array(
                        'email' => $request->emailAuthor,
                        'title' => $request->title,
                        'url' => Str::slug($request->title),
                        'small_content' => $request->small_content,
                        'large_content' => $request->large_content,
                        'categorie' => $request->categorie,
                        'author' => $request->author,
                        'author_content' => $request->author_content,
                        'author_link' => $request->author_link,
                        'source' => $request->sourceArticle,
                        'url_fb' => $request->url_fb,
                        'url_twitter' => $request->url_twitter,
                        'url_linkedin' => $request->url_linkedin,
                        'active' => 1,
                    ));

                    $insert->save();

                    // Logs
                    $logs_user = new Log();
                    $logs_user->log_user(Auth::id(), 'Blog', 'Un nouvel article a été créer !', url()->current(), $request->ip());

                    if (!empty($request->file_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($insert->id) . '_' . time() . '.' . $request->file_0->extension();

                            $request->file_0->move(public_path('img/news'), $fileName);

                            News::where('id', $insert->id)
                                ->update(array(
                                    'image' => $fileName,
                                ));
                        }
                    }

                    if (!empty($request->files_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($insert->id) . '_bandeau_' . time() . '.' . $request->files_0->extension();

                            $request->files_0->move(public_path('img/news'), $fileName);

                            News::where('id', $insert->id)
                                ->update(array(
                                    'image_bandeau' => $fileName,
                                ));
                        }
                    }

                    if (!empty($request->filese_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($insert->id) . '_' . time() . '.' . $request->filese_0->extension();

                            $request->filese_0->move(public_path('img/news/avatar'), $fileName);

                            News::where('id', $insert->id)
                                ->update(array(
                                    'avatar' => $fileName,
                                ));
                        }
                    }

                    return response()->json(['status' => 1, 'msg' => 'Votre article a bien été créer.', 'title' => 'Ajout de l\'article', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
                }
            } else {
                return response()->json(['status' => 0, 'title' => 'Ajout de l\'article', 'toast' => 'toast-error', 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display a dashboard to orders google play.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_orders_google()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $orders_google = DB::table('google_play_orders')
                ->join('projets', 'google_play_orders.Product_ID', '=', 'projets.app')
                ->orderBy('google_play_orders.Order_Charged_Date', 'DESC')
                ->get();

            $total_commandes = DB::table('google_play_orders')
                ->where('Financial_Status', 'Charged')
                ->sum('Item_Price');

            $totals_commandes = DB::table('google_play_orders')
                ->orderBy('Order_Charged_Date', 'DESC')
                ->get();

            $total_commandes_refund = DB::table('google_play_orders')
                ->where('Financial_Status', 'Refund')
                ->sum('Item_Price');


            if (isset($user)) {
                return view('auth.admin.show_orders_google', compact('user', 'orders_google', 'total_commandes', 'totals_commandes', 'total_commandes_refund', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_orders_google', compact('user', 'orders_google', 'total_commandes', 'totals_commandes', 'total_commandes_refund', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Archive mail user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function archive_mail(Request $request)
    {

        if (Auth::check()) {

            $contacts = Contact::where('archive', 0)
                ->where('id', $request->mail_id)
                ->get();

            if (!empty($contacts)) {

                Contact::where('id', $request->mail_id)->update(array(
                    'archive' => 1,
                ));

                // Logs
                $logs_user = new Log();
                $logs_user->log_user(Auth::id(), 'Boîte email', 'Un email dans votre boîte de réception a été archivée !', url()->current(), $request->ip());

                return response()->json(['status' => 1, 'msg' => 'Votre message a été archivée.', 'title' => 'Boîte email', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Votre message a déjà été archivée.', 'title' => 'Boîte email', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    /**
     * Edit user profil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_user_logged(Request $request)
    {

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->first();

            if (isset($user)) {

                $validator = Validator::make($request->all(), [
                    'email' => 'bail|required|email',
                    'lastname' => 'bail|required',
                    'firstname' => 'bail|required'
                ]);


                if (!$validator->passes()) {
                    return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'title' => 'Modification de votre profil !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                } else {

                    if (!empty($request->file_0)) {

                        $validator = Validator::make($request->all(), [
                            'file' => 'mimes:gif,png,jpeg,jpg,svg'
                        ]);

                        if (!$validator->passes()) {
                            return response()->json(['error' => $validator->errors()->toArray(), 'status' => 0, 'msg' => 'L\'avatar doit être au format image !', 'title' => 'Modification de votre profil !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                        } else {
                            $fileName = strtolower($request->lastname . '_' . $request->firstname) . '_' . time() . '.' . $request->file_0->extension();

                            $request->file_0->move(public_path('img/profil'), $fileName);

                            User::where('id', Auth::id())
                                ->update(array(
                                    'avatar' => $fileName,
                                ));

                            // Logs
                            $logs_user = new Log();
                            $logs_user->log_user(Auth::id(), 'Modification profil', 'Votre photo de profil a été modifiée !', url()->current(), $request->ip());
                        }
                    }

                    User::where('id', Auth::id())
                        ->update(array(
                            'lastname' => $request->lastname,
                            'firstname' => $request->firstname,
                            'email' => $request->email,
                            'updated_at' => date('Y/m/d H:i:s')
                        ));

                    // Logs
                    $logs_user = new Log();
                    $logs_user->log_user(Auth::id(), 'Modification profil', 'Votre profil a été modifiée !', url()->current(), $request->ip());

                    return response()->json(['status' => 1, 'msg' => 'Votre profil a été modifiée.', 'title' => 'Modification de votre profil !', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
                }
            } else {
                return response()->json(['status' => 0, 'msg' => 'Une erreur est survenue.', 'title' => 'Modification de votre profil !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }

    /**
     * Display a dashboard to agenda.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_agenda()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();


        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            if (isset($user)) {
                return view('auth.admin.agenda', compact('user', 'contacts'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.agenda', compact('user', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display a dashboard to orders clients.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_orders()
    {

        $user_not_admin = User::where('active', 1)
            ->where('id', Auth::id())
            ->first();

        $contacts = Contact::where('archive', 0)
            ->join('users', 'users.email', '=', 'contacts.email')
            ->where('contacts.to_mail', $user_not_admin->email)
            ->orderBy('contacts.created_at', 'DESC')
            ->limit(6)
            ->get();


        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            $orders_canceled = Orders::where('status', 'CANCELED')->get();
            $orders_refund = Orders::where('status', 'REFUND')->get();
            $orders_success = Orders::where('status', 'COMPLETED')->get();
            $orders_total = Orders::sum('price');
            $orders = Orders::join('products', 'products.product_id', '=', 'orders.product_id')
                ->join('products_contacts', 'products_contacts.id', '=', 'orders.contact_id')
                ->orderBy('orders.created_at', 'DESC')
                ->groupBy('orders.id')
                ->get();

            if (isset($user)) {
                return view('auth.admin.show_orders', compact('user', 'contacts', 'orders_canceled', 'orders_success', 'orders_refund', 'orders_total', 'orders'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_orders', compact('user', 'contacts'));
        }

        return redirect()->route('dashboard');
    }

    /**
     * Display a dashboard to orders refund.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order_refund(Request $request, $id, $transaction)
    {

        if (Auth::check()) {

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->where('admin', 1)
                ->first();

            if (isset($user)) {

                $order_verif = Orders::where('transaction_id', $transaction)
                    ->first();

                if (!empty($order_verif->id)) {

                    $product = Products::where('product_id', $order_verif->product_id)->first();
                    $contact = ProductsContacts::where('id', $order_verif->contact_id)->first();

                    // Remboursement Paypal
                    $provider = new PaypalClient;
                    $provider->setApiCredentials(config('paypal'));
                    $provider->getAccessToken();

                    $response = $provider->refundCapturedPayment($order_verif->capture_id, $order_verif->transaction_id, $order_verif->price, "Demande par le client");

                    if (isset($response['status']) && $response['status'] == 'COMPLETED') {

                        Orders::where('transaction_id', $transaction)
                            ->update(array(
                                'refund_at' => date('Y-m-d H:i:s'),
                                'status' => "REFUND"
                            ));

                        // Logs
                        $logs_user = new Log();
                        $logs_user->log_user(Auth::id(), 'Remboursement d\'une commande', 'La commande n°' .  $transaction . ' a bien été remboursé.', url()->current(), $request->ip());

                        Mail::to($contact->email)
                            ->send(new OrderRefund($order_verif, $product, 'contact@portfolio-gaetan.fr', 'Portefolio', 'Votre paiement n°' . $transaction . ' a été rembourser'));

                        return response()->json(['status' => 1, 'title' => 'Remboursement d\'une commande', 'msg' => 'La commande n°' .  $transaction . ' a bien été remboursé.', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
                    } else {
                        return response()->json(['status' => 0, 'title' => 'Une erreur est survenue.', 'msg' => 'Remboursement de la commande ' . $transaction . ' impossible !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    }
                } else {
                    return response()->json(['status' => 0, 'title' => 'Une erreur est survenue.', 'msg' => 'Remboursement de la commande ' . $transaction . ' impossible !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                }
            } else {
                return response()->json(['status' => 0, 'title' => 'Une erreur est survenue.', 'msg' => 'Remboursement de la commande ' . $transaction . ' impossible !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }
}
