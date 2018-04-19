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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::resource('categories', 'CategoryController');

Route::resource('businesses', 'BusinessController');

Route::get('login', 'BusinessController@login')->name('login');
Route::post('login', 'BusinessController@add_login')->name('login');
Route::delete('logout', 'BusinessController@logout')->name('logout');