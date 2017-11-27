<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thujohn\Twitter\Twitter;
use Illuminate\Support\Facades\Cache;

/**
 * Class TweetController
 * @package App\Http\Controllers
 * @author Rajendra Sharma <drudge.rajan@gmail.com>
 */
class TweetController extends Controller
{

    /**
     * @var Twitter
     */
    private $twitter;

    /**
     * TweetController constructor.
     * @param Twitter $twitter
     */
    public function __construct(Twitter $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * Get Tweets by Latitude and Longitude
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTweetByLatLng(Request $request)
    {
        $lat = $request->get('lat');
        $long = $request->get('lng');


        $cacheKey = $lat . $long;
        $tweets = Cache::remember($cacheKey, env('TWITTER_TTL'), function () use ($lat, $long) {
            $params = $this->prepareRequestParams($lat, $long);
            return $this->getSearchTweets($params);
        });

        return response()->json($tweets);

    }

    /**
     * Prepare Parameters for API Request
     *
     * @param $lat
     * @param $long
     * @return array
     */
    public function prepareRequestParams($lat, $long)
    {
        return $params = [
            'q' => '',
            'geocode' => $lat . ',' . $long . ',' . env('TWITTER_RADIUS'),
            'count' => 100
        ];

    }


    /**
     * Get Search Tweets by parameters
     *
     * @param $params
     * @return array
     */
    public function getSearchTweets($params)
    {
        $tweets = $this->twitter->getSearch($params);
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
        return $data;
    }
}
