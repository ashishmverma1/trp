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

// for homepage
Route::get('/', ['middleware' => 'guest', function () {
    return view('welcome');
}]);

// for authentication
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);

// for articles
Route:resource('articles', 'ArticlesController');

// for comments
Route::post('articles/{id}', 'CommentsController@store');
Route::delete('articles/deletecomment/{id}', 'CommentsController@destroy');

// for votes
Route::post('articles/{id}/vote', 'ArticlesController@storeUpvote');
