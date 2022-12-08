<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::get('user', 'Api\UserController@index');


Route::get('makanan', 'Api\MakananController@index');
Route::get('makanan/{id}', 'Api\MakananController@show');
Route::post('makanan', 'Api\MakananController@store');
Route::put('makanan/{id}', 'Api\MakananController@update');
Route::delete('makanan/{id}', 'Api\MakananController@destroy');;
Route::get('user/{id}', 'Api\UserController@show');
Route::put('user/{id}', 'Api\UserController@update');

// Route::group(['middleware' => 'auth:api'], function () {


//     Route::delete('user/{id}', 'Api\UserController@destroy');
//     Route::post('logout', 'Api\UserController@logout');
// });
