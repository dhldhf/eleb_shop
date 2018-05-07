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

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::post('businesses/{business}/add_pass', 'BusinessController@add_pass')->name('add_pass');
Route::get('businesses/{business}/pass', 'BusinessController@pass')->name('pass');

Route::resource('food_category', 'Food_categoryController');

Route::resource('foods', 'FoodController');

Route::post('/upload', 'UploadController@upload');

Route::resource('activities', 'ActivityController');

Route::resource('orders', 'OrderController');

Route::get('orders/{order}/ship','OrderController@ship')->name('ship');

Route::get('orders_today','OrderController@today')->name('today');

//Route::post('orders_jiti', 'OrderController@orders_jiti')->name('orders_jiti');

Route::get('food_today','Order_goodsController@food_today')->name('food_today');

Route::resource('events', 'EventsController');

Route::get('events/{event}/winning','EventsController@winning')->name('winning');