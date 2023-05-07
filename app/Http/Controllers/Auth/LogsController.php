<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Models\Logs;
use App\Models\Pays;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LogsController extends Controller
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
     * Display a dashboard to logs users.
     *
     * @return \Illuminate\Http\Response
     */
    public function logs()
    {

        $notifications = LoginRegisterController::Notif();

        $pays = Pays::orderBy('id', 'ASC')->get();

        if (Auth::check()) {

            $user_not_admin = User::where('active', 1)
                ->where('id', Auth::id())
                ->first();

            $user = User::where('active', 1)
                ->where('id', Auth::id())
                ->first();

            $contacts = Contact::where('archive', 0)
                ->join('users', 'users.email', '=', 'contacts.email')
                ->where('contacts.to_mail', $user_not_admin->email)
                ->orderBy('contacts.created_at', 'DESC')
                ->limit(6)
                ->get();

            $logs = Logs::where('user_id', Auth::id())
                ->get();

            return view('auth.logs', compact('user', 'contacts', 'logs', 'pays', 'notifications'));
        }

        return redirect()->route('dashboard');
    }
}
