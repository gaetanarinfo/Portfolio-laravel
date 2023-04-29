<?php

namespace App\Functions;

use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class Log
{

    public function log_user($title, $content, $page, $ip)
    {

        Logs::create(array(
            'user_id' => Auth::id(),
            'title' => $title,
            'content' => $content,
            'page' => $page,
            'ip' => $ip
        ));
    }
}
