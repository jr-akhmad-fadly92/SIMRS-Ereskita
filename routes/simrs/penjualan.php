<?php
Route::group(['middleware'=>['web','auth', 'role:administrator|apotik']], function () {
  Route::get('penjualan/formpenjualan/{idpasien?}/{idreg?}/{penjualan_id?}/{bebas?}', 'PenjualanController@form_penjualan');
  Route::get('penjualan/formpermintaan/{idpasien?}/{idreg?}/{permintaan_id?}', 'PenjualanController@formPermintaan');
});
Route::group(['middleware'=>['web','auth']], function () {
  //PENJUALAN RAWAT JALAN
  Route::get('penjualan', 'PenjualanController@index');
  Route::post('penjualan', 'PenjualanController@indexByRequest');
  //IRNA
  /* Route::get('penjualan/irna', 'PenjualanController@rawat_inap');
  Route::post('penjualan/irna', 'PenjualanController@rawat_inap_byTanggal'); */	
  Route::get('penjualan/epo', 'PenjualanController@epo');
  Route::post('penjualan/epo', 'PenjualanController@epo_byTanggal');	
  Route::get('penjualan/retur', 'PenjualanController@retur');
  Route::post('penjualan/retur', 'PenjualanController@retur_byTanggal');  
  Route::post('penjualan/search', 'PenjualanController@search');
  Route::get('penjualan/konfirmasi-resep/{registrasi_id}/{penjualan_id}', 'PenjualanController@konfirmasiResep');
  Route::post('penjualan/savepenjualan', 'PenjualanController@save_penjualan');
  Route::post('penjualan/savedetail', 'PenjualanController@save_detail');
  Route::get('penjualan/deleteDetail/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@deleteDetail');
  Route::get('penjualan/savetotal/{penjualan_id}', 'PenjualanController@save_totalpenjualan');
  Route::get('penjualan/{id}/history', 'PenjualanController@history');	
  Route::post('penjualan/savepermintaan', 'PenjualanController@savePermintaan');
  Route::post('penjualan/savedetailpermintaan', 'PenjualanController@saveDetailPermintaan');
  Route::get('penjualan/deletedetailpermintaan/{id}/{idpasien?}/{idreg?}/{penjualan_id?}/{alasan}', 'PenjualanController@deleteDetailPermintaan');
  Route::get('penjualan/savetotalpermintaan/{penjualan_id}', 'PenjualanController@saveTotalPermintaan');
  Route::post('penjualan/update-status-permintaan', 'PenjualanController@updateStatusPermintaan');
  Route::get('penjualan/edit-permintaan/{id}', 'PenjualanController@getPermintaan');
  Route::get('penjualan/edit-penjualan/{id}', 'PenjualanController@getPenjualan');
  Route::get('penjualan/retur-permintaan/{id}/{jumlah}', 'PenjualanController@returPermintaan');

  //PENJUALAN BEBAS
  Route::get('penjualan-bebas/{registrasi_id}', 'PenjualanController@penjualanBebas');
  Route::get('penjualanbebas', 'PenjualanController@penjualanBebas');
  Route::post('penjualan/savepenjualanbebas', 'PenjualanController@save_penjualan_bebas');
  Route::get('penjualan/formpenjualanbebas/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@form_penjualan_bebas');
  Route::post('penjualan/savedetailbebas', 'PenjualanController@save_detail_bebas');
  Route::get('penjualan/deleteDetailbebas/{id}/{idpasien?}/{idreg?}/{penjualan_id?}', 'PenjualanController@deleteDetailBebas');
  Route::get('penjualan/savetotalbebas/{penjualan_id}', 'PenjualanController@save_totalpenjualan_bebas');

  //UPDATE DETAIL PENJUALAN
  Route::get('detail-penjualan/{penjualan_id}', 'PenjualanController@detailPenjualan');
  Route::get('hapus-detail-penjualan/{id}', 'PenjualanController@hapusObat');
  Route::get('tambah-detail-penjualan/{penjualan_id}', 'PenjualanController@tambahPenjualan');
  Route::post('simpan-detail-penjualan', 'PenjualanController@saveTambahPenjualan');

  //GET MASTER OBAT => COMBOBOX
  Route::get('penjualan/master-obat/', 'PenjualanController@getMasterObat');
  Route::get('penjualan/master-obat/{depo}', 'PenjualanController@getMasterObat');

  //LAPORAN
  Route::get('penjualan/laporan', 'PenjualanController@laporan');
  Route::post('penjualan/laporan', 'PenjualanController@laporanPenjualan');
  Route::get('penjualan/laporan/{no_faktur}', 'PenjualanController@laporanPenjualanDetail');
  // LAPORAN PENJUALAN OBAT
  Route::get('penjualan/laporan-obat', 'PenjualanController@laporanPenjualanobat');
  Route::post('penjualan/laporan-obat', 'PenjualanController@laporanPenjualanobat_request');
  

});
