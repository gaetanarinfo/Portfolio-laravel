<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

// require_once '../vendor/google/apiclient/autoload.php';

class GoogleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showGoogleProjets(Request $request)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://serpapi.com/search?engine=" . $request->section . "&search_query=" . $request->youtubeur . "&api_key=" . env('TOKEN_GOOGLE'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);

        $decodedData = json_decode($response, true);

        curl_close($ch);

        return response()->json($decodedData);
    }
}
