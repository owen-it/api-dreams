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

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

Route::group(['prefix' => 'oauth', 'middleware' => 'cors'], function()
{
    Route::post('access_token', function() {
        return Response::json(Authorizer::issueAccessToken());
    });
    Route::post('register', 'Auth\AuthController@register');
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api', 'middleware' => ['cors', 'oauth']], function()
{
    Route::resource('dream', 'DreamController',['only' => ['index', 'show', 'update', 'store', 'destroy']]);
    Route::get('me/account', 'Auth\AuthController@me');
    Route::get('members', 'Auth\AuthController@users');
});