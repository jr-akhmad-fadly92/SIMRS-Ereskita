<?php
//informasi
Route::view('/informasi', 'informasi.index');
//surat
Route::get('/surat_pulang_paksa/{id}', 'SuratController@surat_paksa_pulang');
Route::get('/pengajuan-invetaris-rusak', 'SuratController@pdf_pengajuan_inv_rusak');
Route::get('/pengajuan-invetaris-hilang', 'SuratController@pdf_pengajuan_inv_hilang');
Route::get('/surat-visum/{id}', 'SuratController@pdf_visum');
Route::post('/surat-visum/create', 'SuratController@create_visum');

Route::get('/surat-keterangan-sehat/{id}', 'SuratController@surat_ket_sehat');
Route::post('/surat-keterangan-sehat/create', 'SuratController@create_ket_sehat');
Route::get('/surat-keterangan-sakit/{id}', 'SuratController@surat_ket_sakit');
Route::get('/surat-persetujuan-tindakan-medis/{id}', 'SuratController@surat_persetujuan_tindakan_medis');
Route::post('/surat-persetujuan-tindakan-medis/create', 'SuratController@create_persetujuan_tindakan_medis');

//surat resep
Route::get('/surat-resep/{id}', 'SuratController@surat_resep_by_request');
Route::get('/surat-resep-kosong', 'SuratController@surat_resep_kosong');
//surat rujukan
Route::get('/surat-rujukan/{id}', 'SuratController@surat_rujukan');
Route::post('/create-surat-rujukan', 'SuratController@create_surat_rujukan');
Route::get('/surat-rujukan-kosong', 'SuratController@surat_rujukan_kosong');