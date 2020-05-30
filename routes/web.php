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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create');
});
Route::get('×××', 
'Admin\AAAController@bbb');

Route::group(['prefix' => 'admin', 'middleware'=>'auth'], function() {
    Route::get('profile/create',
    'Admin\ProfileControlle@add');
    
     Route::post('profile/create',
    'Admin\ProfileControlle@create');
    
    Route::get('profile/edit',
    'Admin\ProfileControlle@edit');
    
    Route::post('profile/edit',
    'Admin\ProfileControlle@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
