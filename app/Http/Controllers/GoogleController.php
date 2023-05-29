<?php

namespace App\Http\Controllers;

use App\Models\Youtubes;
use Illuminate\Http\Request;

// require_once '../vendor/google/apiclient/autoload.php';

class GoogleController extends Controller
{

    public function saveXml()
    {

        $youtubeChanels = Youtubes::where('status', 1)->orderBy('id', 'ASC')->get();

        foreach ($youtubeChanels as $value) {

            $xml = file_get_contents('https://www.youtube.com/feeds/videos.xml?channel_id=' . $value->chanel_id);
            file_put_contents('../public/json/youtube-' . $value->chanel_id . '.xml', $xml);

            $xmlFile = file_get_contents('../public/json/youtube-' . $value->chanel_id . '.xml');

            // Load xml data into xml data object
            $xmldata = simplexml_load_string($xmlFile);

            // Encode this xml data into json
            // using json_encode function
            $jsondata = json_encode($xmldata);

            file_put_contents('../public/json/youtube-' . $value->chanel_id . '.json', $jsondata);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function showGoogleProjets($chanelId = null)
    {

        // Read the JSON file
        $json = file_get_contents('../public/json/youtube-' . $chanelId . '.json');

        // Decode the JSON file
        $json_data = json_decode($json, true);

        return response()->json($json_data['entry']);
    }

    public function YoutubeVideoInfo($videoId = null)
    {

        $url = 'https://www.googleapis.com/youtube/v3/videos?id=' . $videoId . '&key=' . env('GOOGLE_API_KEY') . '&part=snippet,contentDetails,statistics,status';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);

        return $response_a->items[0];
    }
}
