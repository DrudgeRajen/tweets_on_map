<?php
/**
 * Created by PhpStorm.
 * User: drudge
 * Date: 11/27/17
 * Time: 10:32 PM
 */

namespace App\Service;


use Thujohn\Twitter\Twitter;

/**
 * Class TwitterService
 * @package App\Service
 * @author Rajendra Sharma <drudge.rajan@gmail.com>
 */
class TwitterService
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