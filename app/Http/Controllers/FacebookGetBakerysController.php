<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Support\Facades\DB;

class FacebookGetBakerysController extends Controller
{

    protected $facebook;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function get()
    {

        $_appID = env('FACEBOOK_APP_ID');
        $_appSecret = env('FACEBOOK_APP_SECRET');
        $_defaultGraphVersion = "v2.5";

        $fb = new Facebook(['app_id' => $_appID, 'app_secret' => $_appSecret, 'default_graph_version' => $_defaultGraphVersion]);

        function postStatus($status, $fb)
        {

            $_accessToken = env('FACEBOOK_APP_TOKEN');

            try {

                $response = $fb->post('/me/feed', $status, $_accessToken);

                if ($response) $attachments[] = $response['id'];
            } catch (FacebookResponseException $e) {
                throw new Exception($e->getMessage(), $e->getCode());
            } catch (FacebookSDKException $e) {
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }

        $bakerys = DB::connection('mysql')
            ->table('mybakery.bakerys')
            ->select('id', 'url', 'title', 'image', 'small_content')
            ->where('publish_facebook', '!=', 1)
            ->orderBy('id', 'ASC')
            ->limit(1)
            ->get();

        foreach ($bakerys as $value) {

            $status = [
                'link' => 'https://my-bakery.fr/#/bakery/' . $value->url,
                'message' => $value->small_content,
                // 'source' => $fb->fileToUpload(__DIR__ . '/../../../../my-bakery/bakerys/' . $value->image)
            ];

            postStatus($status, $fb);

            DB::connection('mysql')
                ->table('mybakery.bakerys')
                ->where('id', $value->id)
                ->update(array(
                    'publish_facebook' => 1
                ));
        }
    }
}
