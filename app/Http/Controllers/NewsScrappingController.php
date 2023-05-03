<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsScrappingController extends Controller
{

    public function getNewsAll()
    {

        $news = News::get();

        foreach ($news as $value) {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://31.33.145.219:10200/actualite");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "url=" . $value->source . "&id=" . $value->id . "&title=" . $value->title);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo curl_error($ch);
                die();
            }

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == intval(200)) {

                $decodedData = json_decode($response, true);

                foreach ($decodedData['actualite'] as $value) {

                    if ($value['id'] >= 11) {

                        if (empty($value['email'])) {
                            $email = "";
                        } else {
                            $email = $value['email'];
                        }

                        if (empty($value['url_twitter'])) {
                            $url_twitter = "";
                        } else {
                            $url_twitter = $value['url_twitter'];
                        }

                        if (empty($value['url_linkedin'])) {
                            $url_linkedin = "";
                        } else {
                            $url_linkedin = $value['url_linkedin'];
                        }

                        DB::table('news')
                            ->where('id', $value['id'])
                            ->where('updated_at', NULL)
                            ->update(array(
                                "url" => Str::slug($value['title']),
                                "large_content" => $value['large_content'],
                                "image_bandeau" => $value['image_bandeau'],
                                "avatar" => $value['avatar'],
                                "author_content" => $value['author_content'],
                                "author_link" => $value['author_link'],
                                "email" => $email,
                                "url_twitter" => $url_twitter,
                                "url_linkedin" => $url_linkedin,
                                "updated_at" => date('Y-m-d H:i:s'),
                            ));
                    }
                }
            } else {
                echo "Ressource introuvable : " . $http_code;
            }
        }
    }
}
