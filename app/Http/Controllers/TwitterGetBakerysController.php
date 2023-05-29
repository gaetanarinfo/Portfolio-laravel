<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterGetBakerysController extends Controller
{

    protected $facebook;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function get()
    {

        $apiKey = env('TWITTER_API_KEY');
        $apiSecret = env('TWITTER_API_SECRET');
        $accessToken = env('TWITTER_ACCESS_TOKEN');
        $accessSecret = env('TWITTER_ACCESS_SECRET');
        $result = '';

        $tw = new TwitterOAuth(
            $apiKey,
            $apiSecret,
            $accessToken,
            $accessSecret
        );

        $bakerys = DB::connection('mysql')
            ->table('mybakery.bakerys')
            ->select('id', 'url', 'title', 'image')
            ->where('publish_twitter', '!=', 1)
            ->orderBy('id', 'ASC')
            ->limit(30)
            ->get();

        $result = $tw->upload('media/upload', [
            'media' => __DIR__ . '/../../../../my-bakery/bakerys/default.jpg'
        ], true);

        foreach ($bakerys as $value) {

            $data = [
                'text' => 'Une nouvelle boulangerie a été ajouté ' .  $value->title . ' à voir sur https://my-bakery.fr/#/bakery/' . $value->url . ' via @Mybakery7280',
                'media' => [
                    'media_ids' => [$result->media_id_string],
                ]
            ];


            $tw->setApiVersion('2')->post("tweets", $data, true);

            if ($tw->getLastHttpCode() == 429) {
                echo 'Pas de connexion';
            } else {
                DB::connection('mysql')
                    ->table('mybakery.bakerys')
                    ->where('id', $value->id)
                    ->update(array(
                        'publish_twitter' => 1
                    ));
            }
        }
    }
}
