<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        return "Good Morning";
    }

    public function help()
    {
        //return 'hello world!';
        return json_decode(json_encode(url(__DIR__)), true);
    }
}
