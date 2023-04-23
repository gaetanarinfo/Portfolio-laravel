<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showGitProjets(Request $request)
    {

        $authorization = "Bearer " . env('TOKEN_GITHUB');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.github.com/users/gaetanarinfo", // your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/vnd.github.v3+json",
                "Content-Type: text/plain",
                "Authorization: " . $authorization,
                "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $decodedData = json_decode($response, true);

        $curl2 = curl_init();

        curl_setopt_array($curl2, array(
            CURLOPT_URL => "https://api.github.com/users/gaetanarinfo/repos", // your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/vnd.github.v3+json",
                "Content-Type: text/plain",
                "Authorization: " . $authorization,
                "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 YaBrowser/16.3.0.7146 Yowser/2.5 Safari/537.36"
            ],
        ));

        $response2 = curl_exec($curl2);

        curl_close($curl2);

        $decodedData2 = json_decode($response2, true);

        if (!empty($request->input('select'))) {

            if ($request->input('select') == "Les plus ancien") {
                sort($decodedData2);
            } else {
                rsort($decodedData2);
            }

        } else {
            rsort($decodedData2);
        }

        return response()->json(["profil" => $decodedData, "repos" => $decodedData2]);
    }
}
