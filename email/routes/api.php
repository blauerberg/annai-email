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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('email/sendgrid', 'SendGridController@sendgrid_send');
Route::post('email/sparkpost', 'SparkPostController@sparkpost_send');
Route::post('email/sendgrid', 'SendGridController@sendgrid_send_api');
Route::post('email/sparkpost', 'SparkPostController@sparkpost_send_api');
