<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateMyBakeryController extends Controller
{

    public function update()
    {

        $bakerys = DB::connection('mysql')
            ->table('mybakery.bakerys')->get();

        foreach ($bakerys as $value) {

            $counter_devanture = '';
            $sum_devanture = '';
            $counter_proprete = '';
            $sum_proprete = '';
            $counter_choix = '';
            $sum_choix = '';
            $counter_prix = '';
            $sum_prix = '';

            echo $value->id . '<br><br>';

            $counter_devanture .= DB::connection('mysql')
                ->table('mybakery.bakerys_devanture')->where('bakery_id', $value->id)->count('id');

            $sum_devanture .= DB::connection('mysql')
                ->table('mybakery.bakerys_devanture')->where('bakery_id', $value->id)->sum('note');

            $counter_proprete .= DB::connection('mysql')
                ->table('mybakery.bakerys_proprete')->where('bakery_id', $value->id)->count('id');

            $sum_proprete .= DB::connection('mysql')
                ->table('mybakery.bakerys_proprete')->where('bakery_id', $value->id)->sum('note');

            $counter_choix .= DB::connection('mysql')
                ->table('mybakery.bakerys_choix')->where('bakery_id', $value->id)->count('id');

            $sum_choix .= DB::connection('mysql')
                ->table('mybakery.bakerys_choix')->where('bakery_id', $value->id)->sum('note');

            $counter_prix .= DB::connection('mysql')
                ->table('mybakery.bakerys_prix')->where('bakery_id', $value->id)->count('id');

            $sum_prix .= DB::connection('mysql')
                ->table('mybakery.bakerys_prix')->where('bakery_id', $value->id)->sum('note');

            DB::connection('mysql')
                ->table('mybakery.bakerys')
                ->where('id', $value->id)
                ->update(array(
                    'counter_devanture' => $counter_devanture,
                    'sum_devanture' => $sum_devanture,
                    'counter_proprete' => $counter_proprete,
                    'sum_proprete' => $sum_proprete,
                    'counter_choix' => $counter_choix,
                    'sum_choix' => $sum_choix,
                    'counter_prix' => $counter_prix,
                    'sum_prix' => $sum_prix
                ));
        }
    }

    public function getBakerys()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://boulangerieinfo.com/page/1/?s=paris", // your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        if (curl_errno($curl)) {
            echo curl_error($curl);
            die();
        }

        $response = curl_exec($curl);

        curl_close($curl);

        $decodedData = json_decode($response, true);

        var_dump($decodedData);
    }
}
