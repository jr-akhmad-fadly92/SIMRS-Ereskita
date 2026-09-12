<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('pemeriksaanlab', 'PemeriksaanLabController@index');
  Route::post('pemeriksaanlab', 'PemeriksaanLabController@index_byTanggal');
  Route::get('pemeriksaanlab/create/{id?}/{labid?}', 'PemeriksaanLabController@create');
  Route::post('pemeriksaanlab/store', 'PemeriksaanLabController@store');
  Route::post('pemeriksaanlab/save-hasil', 'PemeriksaanLabController@saveHasil');
  Route::post('pemeriksaanlab/saverincian', 'PemeriksaanLabController@save_rincian');
  Route::get('pemeriksaanlab/cetak/{registrasi_id?}/{hasillab_id}', 'PemeriksaanLabController@cetak_hasil_lab');
  Route::get('pemeriksaanlab/cetakpasien/{registrasi_id?}', 'PemeriksaanLabController@cetak_hasil_lab1');
  Route::get('pemeriksaanlab/update-cetak/{id}/{ischecked}', 'PemeriksaanLabController@updateCetak');

  Route::get('pemeriksaanlab/getkategori/{id}', 'PemeriksaanLabController@get_kategori');
  Route::get('pemeriksaanlab/getlab/{id}', 'PemeriksaanLabController@get_laboratoria');
  Route::get('pemeriksaanlab/deletedetail/{registrasi_id}/{lab_id}/{id}', 'PemeriksaanLabController@deleteDetail');
});
