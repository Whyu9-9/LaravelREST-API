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
Route::post('user_info','Api\AuthController@read')->middleware('jwtAuth');
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');
Route::post('save_user_info','Api\AuthController@saveUserInfo')->middleware('jwtAuth');
Route::post('edit_user_info','Api\AuthController@editUserInfo')->middleware('jwtAuth');
Route::post('user_edit_pass','Api\AuthController@editPass')->middleware('jwtAuth');

//reminder
Route::post('reminder/create','Api\PengobatansController@create')->middleware('jwtAuth');
Route::post('reminder/update','Api\PengobatansController@update')->middleware('jwtAuth');
Route::post('reminder/delete','Api\PengobatansController@delete')->middleware('jwtAuth');
Route::get('reminder','Api\PengobatansController@reminder')->middleware('jwtAuth');
Route::get('reminder/trash','Api\PengobatansController@trash')->middleware('jwtAuth');