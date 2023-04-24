<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\User;
use App\Models\Projets;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
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
                return view('auth.admin.show_users', compact('user', 'users', 'users_active', 'users_banned'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_users', compact('user', 'users'));
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
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Modification d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
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
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Création d\'un utilisateur !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                $insert = User::create(array(
                    'lastname' => $request->lastname,
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'active' => $request->active
                ));

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
                return view('auth.admin.show_projets', compact('user', 'projets', 'projets_active', 'projets_inactive'));
            } else {
                return redirect()->route('dashboard');
            }

            return view('auth.admin.show_projets', compact('user', 'projets'));
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
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Modification d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($request->projet_id) . '_' . time() . '.' . $request->file_0->extension();

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
                return response()->json(['error' => $error, 'status' => 0, 'msg' => 'Vos informations sont erronées !', 'title' => 'Création d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            } else {

                $insert = Projets::create(array(
                    'categorie' => $request->categorie,
                    'title' => $request->title,
                    'url' => $request->url,
                    'prix' => str_replace(',', '.', $request->prix),
                    'active' => $request->active
                ));

                if (!empty($request->file_0)) {

                    $validator = Validator::make($request->all(), [
                        'file' => 'mimes:gif,png,jpeg,jpg,svg'
                    ]);

                    if (!$validator->passes()) {
                        return response()->json(['error' => $error, 'status' => 0, 'msg' => 'L\'image doit être au format image !', 'title' => 'Création d\'un projet !', 'toast' => 'toast-error', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
                    } else {
                        $fileName = strtolower($request->lastname . '_' . $request->firstname) . '_' . time() . '.' . $request->file_0->extension();

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
}
