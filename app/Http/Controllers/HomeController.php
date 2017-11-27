<?php

namespace App\Http\Controllers;


use App\Service\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Factory as ViewFactory;

/**
 * Class HomeController
 * @package App\Http\Controllers
 * @author Rajendra Sharma <drudge.rajan@gmail.com>
 */
class HomeController extends Controller
{


    /**
     * @var ViewFactory
     */
    private $view;

    /**
     * @var TwitterService
     */
    private $twitterService;

    /**
     * HomeController constructor.
     * @param ViewFactory $view
     * @param TwitterService $twitterService
     */
    public function __construct(ViewFactory $view,TwitterService $twitterService)
    {
        $this->view = $view;
        $this->twitterService = $twitterService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->view->make('index');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTweetByLatLng(Request $request)
    {
        $lat = $request->get('lat');
        $long = $request->get('lng');

        $cacheKey = $lat . $long;
        $tweets = Cache::remember($cacheKey, env('TWITTER_TTL'), function () use ($lat, $long) {
            $params = $this->twitterService->prepareRequestParams($lat, $long);
            return $this->twitterService->getSearchTweets($params);
        });

        return response()->json($tweets);
    }
}
