<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 25/08/2017
 * Time: 12:00
 */

namespace App\Http\Controllers\Rbac;


use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList()
    {
        
    }
}