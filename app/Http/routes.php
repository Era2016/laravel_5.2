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
        return view('welcome');
    });
    Route::get('/home', 'HomeController@index');
});

Route::group(['prefix' => 'rbac','namespace' => 'Rbac', 'middleware' => 'auth'], function () {
    Route::get('show', 'ShowController@getAuthList');
    Route::get('user/get-list', 'UserController@getList');

    Route::post('user/assign-role', 'UserController@assignRole');
    Route::post('user/un-assign-role', 'UserController@unAssignRole');



    Route::any('user/rbac-test', function () {
        return 'Access pass!';
    });
});
Route::auth();

Route::get('/home', 'HomeController@index');
