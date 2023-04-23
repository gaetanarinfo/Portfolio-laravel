<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\View\View;
use App\Mail\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{

    public function create(): View
    {
        return view('home');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'bail',
            'email' => 'bail|required|email'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'title' => 'Newsletter', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => 'Il semble y avoir des erreurs dans le formulaire !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
        } else {

            $newsletters = DB::table('newsletters')
                ->where('email', $request->email)
                ->orderBy('created_at', 'desc')
                ->get();

            if (count($newsletters) <= 0) {

                \App\Models\Newsletter::create([
                    'email' => $request->email,
                    'token' => $request->token
                ]);

                Mail::to($request->email)
                    ->send(new Newsletter($request->except('_token'), 'contact@portfolio-gaetan.fr', 'Portefolio', 'Inscription à notre lettre d\'actualité'));

                return response()->json(['status' => 1, 'msg' => 'Merci pour votre inscription à notre lettre d\'actualité vous allez recevoir prochainement des nouvelles de notre part, merci à bientôt.', 'title' => 'Newsletter', 'toast' => 'toast-success', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check mr-2" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>']);
            } else {
                return response()->json(['status' => 0, 'title' => 'Newsletter', 'toast' => 'toast-error', 'error' => $validator->errors()->toArray(), 'msg' => $request->email . ' est déjà présent, dans notre lettre d\'actualité !', 'icone' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill mr-2" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>']);
            }
        }
    }
}
