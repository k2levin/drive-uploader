<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * home index page
     * @return mixed
     */
    public function index()
    {
        return view('home.index');
    }

    /**
     * home about page
     * @return mixed
     */
    public function about()
    {
        return view('home.about');
    }
}
