<?php

namespace App\Http\Controllers;

use Validator;
use App\Mail\Contact;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{

    public function create(): View
    {
        return view('home');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'bail',
            'name' => 'bail|required',
            'email' => 'bail|required|email',
            'sujet' => 'bail|required',
            'message' => 'bail|required|max:500'
        ]);


        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'title' => 'Formulaire de contact', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            \App\Models\Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'sujet' => $request->sujet,
                'message' => $request->message,
                'token' => $request->token,
            ]);

            Mail::to('contact@portfolio-gaetan.fr')
                ->send(new Contact($request->except('_token'), $request->email, $request->name, $request->sujet));

            return response()->json(['status' => 1, 'msg' => 'Votre demande a bien été envoyée, merci à bientôt.', 'title' => 'Formulaire de contact', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
        }
    }
}
