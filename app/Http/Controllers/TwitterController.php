<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thujohn\Twitter\Twitter;

class TwitterController extends Controller
{

    private $twitter;

    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    public function getTweetByLatLng(Request $request)
    {
        $lat = $request->get('lat');
        $long = $request->get('lng');
        $params = [
            'q' => '',
            'geocode' => $lat . ',' . $long . ',' . env('TWITTER_RADIUS'),
            'until' => '2017-11-19',
            'count' => 100
        ];

        $tweets = $this->twitter->getSearch($params);


        $parsedTweets =  $this->parseTweets($tweets);

        return response()->json($parsedTweets);
    }


    public function parseTweets($tweets)
    {
        $data = [];
        foreach ($tweets->statuses as $key => $tweet) {
            if ($tweet->geo) {
                $data[] = [
                    'url' => isset($tweet->entities->urls[0]->expanded_url) ? $tweet->entities->urls[0]->expanded_url : '',
                    'id_user' => $tweet->user->id,
                    'screen_name' => $tweet->user->screen_name,
                    'profile_img' => $tweet->user->profile_image_url,
                    'text' => $tweet->text,
                    'lat' => $tweet->geo->coordinates[0],
                    'lng' => $tweet->geo->coordinates[1]
                ];
            }
        }
//        dd($data);
        return $data;
    }
}
