<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwitterController extends Controller
{


    public function getTweetByLatLng(Request $request)
    {
        dd($request->all());
    }
}
