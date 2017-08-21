<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

Route::get('welcome', function () {
    return "hello world";
});

// 带参数路由
Route::get('/name/{name}', function ($name) {
    return 'I am '. $name;
});

// 重命名路由
Route::get('foo', ['as' => 'test', function () {
    return 'hello world';
}]);

Route::get('help', function () {
    return url('help');
});

Route::get('test/help', 'HomeController@help');
Route::get('test', 'HomeController@index');*/

/*Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        // 该路由将使用 Auth 中间件
        return 'hello world';
    });

    Route::get('/home', 'HomeController@index');
});

Route::get('login', function () {
    return 'bye';
});

// 给应用注册特定路由：认证，注册，密码重置
/*
 * TODO 调用顺序/时机
 * redirect()->guest('login') 触发
 * redirect()->guest('register') 触发
 * 该值去路由表中查找auth路由
 * 并将该值作为参数，重定向login或者register
 *
 * Route::auth()作为一个路由入口，进行转发
 */
Route::auth();

//Route::get('/home', 'HomeController@index');
