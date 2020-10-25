<?php

use Illuminate\Http\Request;

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

//user
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');

//reminder
Route::post('reminder/create','Api\PengobatansController@create')->middleware('jwtAuth');
Route::post('reminder/update','Api\PengobatansController@update')->middleware('jwtAuth');
Route::post('reminder/delete','Api\PengobatansController@delete')->middleware('jwtAuth');
Route::get('reminder','Api\PengobatansController@reminder')->middleware('jwtAuth');