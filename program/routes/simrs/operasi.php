<?php

Route::group(['middleware'=>['web','auth','role:rawatinap|rawatdarurat|operasi|administrator']], function () {
  Route::view('operasi/billing', 'operasi.billing');
  Route::view('operasi/laporan', 'operasi.laporan');
  // penggunaan kamar operasi ====================================================================
  Route::get('operasi/laporan/penggunaan_kamar_operasi', 'OperasiController@laporankamaroperasi');
  Route::post('operasi/laporan/penggunaan_kamar_operasi', 'OperasiController@laporankamaroperasi_byrequest');
  Route::get('operasi/laporan/detail_operasi_pasien/{id}', 'OperasiController@detail_operasi_pasienpdf');
  //Route::post('operasi/laporan/detail_operasi_pasienpdf', 'OperasiController@detail_operasi_pasienpdf');
  
  Route::get('operasi/antrian/{tgl?}', 'OperasiController@antrian');
  Route::post('operasi/pertanggal', 'OperasiController@byTanggal');
  Route::get('operasi/tindakan/{registrasi_id}', 'OperasiController@tindakan');
  Route::post('operasi/simpan-tindakan', 'OperasiController@simpanTindakan');
  Route::post('operasi/simpan-order', 'OperasiController@simpanOrder');
  Route::post('operasi/simpan-order-operasi', 'OperasiController@simpanOrderOperasi');
  Route::get('operasi/hapus-jenisorder/{id}/{reg_id}', 'OperasiController@hapusJenisOrder');
  Route::get('operasi/selesai/{reg_id}', 'OperasiController@selesai');
  Route::post('operasi/ppi', 'OperasiController@ppi');

  Route::get('operasi/get-tarif/{kat_id}', 'OperasiController@gettarif');
});
