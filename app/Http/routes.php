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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});

Route::group(['prefix' => 'api/basic' , 'middleware' => 'auth.basic.once'],function($app)
{
    Route::get('/users', function () {
        return response()->json(Auth::user());
    });
});

Route::group(['prefix' => '/api' , 'middleware' => 'oauth'],function($app)
{
    Route::get('/users', function () {
        $user = \App\User::find(Authorizer::getResourceOwnerId());
        return response()->json($user);

        //Auth::loginUsingId($user->id);
        //return response()->json(Auth::user());
    });
});

Route::post('oauth/access_token', function() {
    return response()->json(\LucaDegasperi\OAuth2Server\Facades\Authorizer::issueAccessToken());
});