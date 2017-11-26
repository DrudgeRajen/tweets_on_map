<?php

namespace App\Http\Controllers;


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
     * HomeController constructor.
     * @param ViewFactory $view
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return $this->view->make('index');
    }
}
