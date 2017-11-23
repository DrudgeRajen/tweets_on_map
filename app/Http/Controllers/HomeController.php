<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\Factory as ViewFactory;

class HomeController extends Controller
{


    private $view;

    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    public function index()
    {
        return $this->view->make('index');
    }
}
