<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhoisDomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDomain(Request $request)
    {

        $domain = substr($request->domain, 0, strpos($request->domain, "."));

        $listDomain = [
            ".fr",
            ".com",
            ".store",
            ".shop",
            ".cloud",
            ".art",
            ".online",
            ".paris",
            ".press",
            ".us",
            ".me",
            ".wyz",
            ".ink",
            ".click",
            ".net",
            ".org"
        ];

        $test = array();

        foreach ($listDomain as $value) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.whoisfreaks.com/v1.0/whois?whois=live&domainName=' . $domain . $value . '&apiKey=' . env('TOKEN_WHOIS_DOMAIN'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            $decodedData = json_decode($response, true);

            curl_close($curl);

            array_push($test, $decodedData);

        }

        return response()->json($test);

    }
}
