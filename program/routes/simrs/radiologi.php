<?php
Route::group(['middleware'=>['web','auth','role:rawatinap|rawatdarurat|rawatjalan|radiologi|administrator']], function () {
  Route::get('radiologi/entry-tindakan/{idreg}/{idpasien}','RadiologiController@entryTindakan');
  Route::get('radiologi/tindakan-pasien', 'RadiologiController@tindakan_pasien');
  Route::post('radiologi/save-order', 'RadiologiController@simpanOrder');
  Route::get('radiologi/hapus-jenisorder/{id}/{reg_id}', 'RadiologiController@hapusJenisOrder');
  Route::post('radiologi/update-pelaksana', 'RadiologiController@updatePelaksana');
  Route::get('radiologi/selesai/{reg_id}', 'RadiologiController@selesai');
		
		
	//tindakanIRJ
	Route::get('radiologi/tindakan-irj','RadiologiController@tindakanIRJ');
	Route::post('radiologi/tindakan-irj','RadiologiController@tindakanIRJByTanggal');
	Route::get('radiologi/entry-tindakan-irj/{idreg}/{idpasien}','RadiologiController@entryTindakanIRJ');
	Route::post('radiologi/save-tindakan','RadiologiController@saveTindakan');

	//Insert Kunjungan
	Route::get('radiologi/insert-kunjungan/{registrasi_id}/{pasien_id}','RadiologiController@insertKunjungan');

	//tindakanIGD
	Route::get('radiologi/tindakan-ird','RadiologiController@tindakanIRD');
	Route::post('radiologi/tindakan-ird','RadiologiController@tindakanIRDByTanggal');

	//tindakanIRNA
	Route::get('radiologi/tindakan-irna','RadiologiController@tindakanIRNA');
	Route::post('radiologi/tindakan-irna','RadiologiController@tindakanIRNAByTanggal');
	Route::get('radiologi/entry-tindakan-irna/{idreg}/{idpasien}','RadiologiController@entryTindakanIRNA');

	Route::get('radiologi/hasil/{id}','RadiologiController@hasilRadiologi');
	Route::post('radiologi/save-hasil','RadiologiController@simpanHasilRadiologi');
	Route::get('radiologi/q/{tipe}/{id}','RadiologiController@cetakHasilRadiologi');
	Route::get('radiologi/q/{id}','RadiologiController@cetakHasilRadiologipasien');
	Route::view('radiologi/billing','radiologi.billing');
	Route::view('radiologi/template','radiologi.template');
	Route::view('radiologi/laporan','radiologi.laporan');

	Route::view('radiologi/template','radiologi.template');
	Route::view('radiologi/hasil-radiologi','radiologi.hasil_radiologi');

	//LAPORAN KUNJUNGAN
	Route::get('radiologi/laporan-kunjungan','RadiologiController@lap_kunjungan');
	Route::post('radiologi/laporan-kunjungan','RadiologiController@lap_kunjungan_by_request');

	//Transaksi Langsung
	Route::get('radiologi/transaksi-langsung','RadiologiController@transaksiLangsung');
	Route::post('radiologi/simpan-transaksi-langsung','RadiologiController@simpanTransaksiLangsung');
	Route::get('radiologi/entry-transaksi-langsung/{registrasi_id}','RadiologiController@entryTindakanLangsung');

	//Hapus Tindakan
	Route::get('radiologi/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}','RadiologiController@hapusTindakan');
	Route::get('radiologi/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}/{order}','RadiologiController@hapusTindakan');
});
