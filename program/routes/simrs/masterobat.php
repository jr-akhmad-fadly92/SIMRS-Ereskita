<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::resource('supliyer','SupliyerController');
  Route::resource('satuanbeli','SatuanbeliController');
  Route::resource('satuanjual','SatuanjualController');
  Route::resource('kategoriobat','KategoriobatController');
  Route::resource('masterobat','MasterobatController');
  Route::get('obat/getdata', 'MasterobatController@getData')->name('obat.getdata');
  Route::get('obat/getstoklimit', 'MasterobatController@get_stok_limit');
  Route::get('obat/getstokexplied', 'MasterobatController@get_stok_kadaluarsa');
  Route::get('obat/getgetstoknull', 'MasterobatController@get_stok_date_null');
  Route::post('update_margin', 'MasterobatController@update_margin');
  Route::post('update_harga_apotik', 'MasterobatController@update_harga_apotik');
  Route::post('update_expired_null', 'MasterobatController@update_expired_null');
  
});
