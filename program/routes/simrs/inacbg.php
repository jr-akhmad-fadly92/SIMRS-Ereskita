<?php

Route::post('eklaim/new-claim', 'InacbgController@new_claim');
Route::get('inacbg/data-detail-per-claim/{sep}', 'InacbgController@MengambilDataDetailPerklaim');
Route::get('eklaim/bridging-rincian-biaya/{registrasi_id}', 'InacbgController@rincianBiaya');
Route::get('eklaim/hapus-data-klaim/{regid}/{nomor_rm}/{coder_nik}', 'InacbgController@MenghapusKlaim');
Route::get('eklaim/hapus-data-pasien/{regid}/{nomor_rm}/{coder_nik}', 'InacbgController@HapusDataPasien');
Route::post('eklaim/buat-klaim-baru', 'InacbgController@BuatKlaimBaru');
Route::get('eklaim/grouper-stage2/{no_sep}', 'InacbgController@GroupingStage2');
Route::post('eklaim/detail-klaim', 'InacbgController@MengambilDataDetailPerklaim');
Route::get('eklaim/final-klaim/{nomor_sep}', 'InacbgController@FinalisasiKlaim');
Route::get('eklaim/kirim-dc/{nomor_sep}', 'InacbgController@KirimKlaimIndividualKeDC');
Route::post('eklaim/status-klaim', 'InacbgController@MengambilSetatusPerklaim');
Route::get('eklaim-get-response/{no_sep}', 'InacbgController@getResponse');
Route::get('eklaim-detail-bridging/{registrasi_id}', 'InacbgController@detailBridging');
Route::get('eklaim-rincian-biaya-perawatan/{registrasi_id}', 'InacbgController@cetakBiayaPerawatan');
Route::get('eklaim-detail-rincian-biaya-eklaim/{registrasi_id}', 'InacbgController@cetakDetailEklaim');

//Rawat Inap
Route::post('newclaim-irna', 'InacbgIRNAController@new_claim');

//Test Tarif
Route::get('claim/test-tarif/{registrasi_id}', 'InacbgIRNAController@tesTarif');
