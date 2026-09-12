<?php
Route::group(['middleware'=>['web','auth','role:rawatjalan|administrator']], function () {
  Route::view('rawat-jalan/billing-system', 'rawat-jalan.billing');
  Route::view('rawat-jalan/billing', 'rawat-jalan.billing');
  Route::view('rawat-jalan/emr', 'rawat-jalan.emr');
  Route::view('rawat-jalan/laporan', 'rawat-jalan.laporan');
});
