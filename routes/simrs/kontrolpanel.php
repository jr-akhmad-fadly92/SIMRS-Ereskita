<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::view('/kontrolpanel/konfigurasi','kontrolpanel.konfigurasi');
  Route::view('/kontrolpanel/pengguna','kontrolpanel.pengguna');
  Route::view('/kontrolpanel/keuangan','kontrolpanel.keuangan');
  Route::view('/kontrolpanel/medis','kontrolpanel.medis');
  Route::view('/kontrolpanel/import','kontrolpanel.import');
  Route::view('/kontrolpanel/sif','kontrolpanel.sif');
  Route::view('/kontrolpanel/sif_online','kontrolpanel.sif_online');
  Route::get('/kontrolpanel/sif_online/get','KontrolpanelController@getsifonline');
  Route::get('/kontrolpanel/sif_online/update','KontrolpanelController@update');
  //Sif
  Route::post('/kontrolpanel/sif/update','KontrolpanelController@updatesif');
});
