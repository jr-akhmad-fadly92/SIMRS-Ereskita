<?php
//Route::group(['middleware'=>['web','auth','role:rawatdarurat|administrator']], function () {
Route::group(['middleware'=>['web','auth']], function () {
 
  Route::view('igd/billing', 'igd.billing');
  Route::view('igd/emr', 'igd.emr');
  Route::view('igd/askep', 'igd.askep');
  Route::view('igd-laporan', 'igd.laporan');
  Route::get('igd-laporan-pengunjung', 'IgdController@lap_pengunjung');
  Route::post('igd-laporan-pengunjung', 'IgdController@lap_pengunjung_byRequest');
  Route::post('igd-laporan-pengunjung-excel', 'IgdController@lap_pengunjung_excel');
  
});
