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

// Route::get('/book', function () {
//     return view('booking');
// });

Route::get('/kota','GetCityController@getCity');

Route::get('/','GetDataController@getData');

Route::get('/tipe/{tipe}','SearchDataController@listProduct');
Route::get('/cari','SearchDataController@searchData');
Route::get('/detail/{Id}','SearchDataController@detail');

Route::get('/book/{Id}','BookingController@booking');
Route::post('/book/process','BookingController@bookingProcess');
// Route::post('/book/process', function(){
// 	return 'bebek';
// });
