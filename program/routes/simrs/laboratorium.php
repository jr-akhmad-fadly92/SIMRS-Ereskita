<?php
// Master
Route::group(['middleware'=>['web','auth','role:rawatinap|rawatdarurat|rawatjalan|laboratorium|administrator']], function () {
  Route::resource('labsection', 'LabsectionController');
  Route::resource('labkategori', 'LabkategoriController');
  Route::resource('lab', 'LaboratoriumController');

  Route::view('laboratorium/billing','laboratorium.billing');
  Route::view('laboratorium/hasil','laboratorium.hasil');
  Route::view('laboratorium/master','laboratorium.master');
  Route::view('laboratorium/laporan','laboratorium.laporan');
  Route::get('laboratorium/insert-kunjungan/{registrasi_id}/{pasien_id}','LaboratoriumController@insertKunjungan');
  Route::get('laboratorium/entry-tindakan/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakan');
  Route::post('laboratorium/save-tindakan', 'LaboratoriumController@saveTindakan');
  Route::post('laboratorium/simpan-transaksi-langsung/', 'LaboratoriumController@simpanTransaksiLangsung');
  Route::get('laboratorium/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}', 'LaboratoriumController@hapusTindakan');
  Route::get('laboratorium/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}/{order}', 'LaboratoriumController@hapusTindakan');
  Route::get('laboratorium/cetakRincianLab/{registrasi_id}', 'LaboratoriumController@cetakRincianLab');
  Route::get('laboratorium/laporan-kunjungan','LaboratoriumController@lap_kunjungan');
  Route::post('laboratorium/laporan-kunjungan','LaboratoriumController@lap_kunjungan_by_request');
  Route::get('laboratorium/tindakan-pasien', 'LaboratoriumController@tindakan_pasien');
  Route::post('laboratorium/update-pelaksana', 'LaboratoriumController@updatePelaksana');
  Route::get('laboratorium/selesai/{reg_id}', 'LaboratoriumController@selesai');



  //view list pasien
  /* Route::get('laboratorium/tindakan-irj', 'LaboratoriumController@tindakanIRJ');
  Route::post('laboratorium/tindakan-irj', 'LaboratoriumController@tindakanIRJByTanggal');
  Route::get('laboratorium/tindakan-ird', 'LaboratoriumController@tindakanIRD');
  Route::post('laboratorium/tindakan-ird', 'LaboratoriumController@tindakanIRDByTanggal');
  Route::get('laboratorium/tindakan-irna', 'LaboratoriumController@tindakanIRNA');
  Route::post('laboratorium/tindakan-irna', 'LaboratoriumController@tindakanIRNAByTanggal');

  Route::get('laboratorium/entry-tindakan-irj/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRJ');
  Route::get('laboratorium/entry-tindakan-irna/{idreg}/{idpasien}', 'LaboratoriumController@entryTindakanIRNA');
  Route::get('laboratorium/entry-transaksi-langsung/{registrasi_id}','LaboratoriumController@entryTindakanLangsung');
  Route::get('laboratorium/entry-tindakan-langsung/', 'LaboratoriumController@tindakanLangsung'); */
});
