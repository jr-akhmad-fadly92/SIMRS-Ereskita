<?php
Route::group(['middleware'=>['web','auth','role:administrator|kasir|dokter']], function () {
  Route::resource('dokter','DokterController');
  Route::get('/pendapatan_dokter','DokterController@pendapatan_dokter');
  Route::post('/pendapatan_dokter','DokterController@pendapatan_dokter_byrequest');
 
});
Route::group(['middleware'=>['web','auth','role:rawatjalan|dokter']], function () {
  
  Route::get('/pendapatan_dokter/cek','DokterController@cek_pendapatan_dokter');
  Route::post('/pendapatan_dokter/cek/detail','DokterController@cek_pendapatan_dokter_byrequest');
  
  
});
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('/pendapatan_dokter/cek','DokterController@cek_pendapatan_dokter');
  Route::post('/pendapatan_dokter/cek/detail','DokterController@cek_pendapatan_dokter_byrequest');
 
  Route::get('pendapatan_dokter/data={dokter_id}/{tga}/{tgb}','DokterController@data_pendapatan_dokter');
  Route::get('pendapatan_dokter/{tga}sampai{tgb}/{detail}','DokterController@detail_pendapatan_dokter');
  Route::get('detail_pendapatan_dokter/{tga}sampai{tgb}/{detail}','DokterController@pdf_detail_pendapatan_dokter');
});
