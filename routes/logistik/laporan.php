<?php
Route::group(['middleware'=>['web','auth','role:administrator|logistik']], function () {
 
  // laporan
  // laporan pemesanan
  Route::get('/laporan/pemesanan','LaporanController@pemesanan');  
  Route::post('/laporan/pemesanan','LaporanController@pemesanan_Byrequest');
  //laporan stok
  Route::get('/laporan/stok_gudang','LaporanController@stok_gudang');  
  Route::post('/laporan/stok_gudang','LaporanController@stok_gudang_Byrequest');

});
