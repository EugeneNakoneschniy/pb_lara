<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user', [
    'uses' => 'UserController@store'
]);
Route::post('/user/signin', [
    'uses' => 'UserController@signin'
]);
Route::get('/users', 'UserController@index');

Route::middleware('jwt.auth')->group(function (){
    /* Users routes */

    //Route::get('/users', 'UserController@index');
    Route::get('/user/{id}', 'UserController@show');

    /* Posts routes */

    Route::get('/posts', 'PostController@index'); // all posts
    Route::get('/post/{id}', 'PostController@show'); // single post
    Route::post('/post', 'PostController@store'); // create a new post
    Route::put('/post/{id}', 'PostController@update'); // update post
    Route::delete('/post/{id}', 'PostController@destroy'); // delete post
    Route::delete('/post/force/{id}', 'PostController@destroyForce'); // delete post
    Route::post('/post/restore/{id}', 'PostController@restore'); // restore post
});