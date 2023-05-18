<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateMyBakery extends Controller
{

    public function update()
    {

        DB::connection('mysql')
            ->table('my-bakery')
            ->update(['name' => 'John']);

    }
}
