<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Email Routes.
Route::get('email', 'EmailController@create')->name('email.create');
Route::get('email/success', 'EmailController@success')->name('email.success');
Route::post('email', 'EmailController@store')->name('email.store');
