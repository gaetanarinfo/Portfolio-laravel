<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GooglePlayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showGoogleProjets(Request $request)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://androidpublisher.googleapis.com/androidpublisher/v3/applications/dofus.book/reviews");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Authorization: Bearer ' . $request->cookie('token_special');

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        $decodedData = json_decode($response, true);

        curl_close($ch);

        return response()->json($decodedData);
    }
}
