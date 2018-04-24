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

//Route::get('/oos', function()
//{
//    //D:\www\eleb_shop\storage\app\public\businesses\2zJMqJd1MKJ6pDBhx7CC4V3rj3s1TP4RCNhACsfT.jpeg
//    $client = App::make('aliyun-oss');
//    try{
//        $client->uploadFile(getenv('OSS_BUCKET'), 'public\businesses\2zJMqJd1MKJ6pDBhx7CC4V3rj3s1TP4RCNhACsfT.jpeg', Storage_path('app\public\businesses\2zJMqJd1MKJ6pDBhx7CC4V3rj3s1TP4RCNhACsfT.jpeg'));
//        echo '上传成功';
//    } catch(\OSS\Core\OssException $e) {
//        echo "上传失败";
//        printf($e->getMessage() . "\n");
//        return;
//    }
//});