<?php

Route::group(['middleware' => ['web', 'auth', 'role:admission|rawatinap|rekammedis|kamarbersalin|costing|supervisor-costing|administrator']], function () {
	Route::view('rawat-inap/admission', 'rawat-inap.admission');
	Route::view('rawat-inap/emr', 'rawat-inap.emr');
	Route::view('rawat-inap/laporan', 'rawat-inap.laporan');

	//BILLING
	Route::get('rawat-inap-menu-billing', 'RawatinapController@menuBilling');
	Route::get('rawat-inap/billing/{kelas_id?}/{kamar_id?}', 'RawatinapController@billing');
	Route::post('rawat-inap/billing', 'RawatinapController@pilihKelas');
	/* Route::get('rawat-inap/entry-tindakan/{registrasi_id}', 'RawatinapController@entry_tindakan');
	Route::post('rawat-inap/entry-tindakan/save', 'RawatinapController@save_tindakan'); */

	//Update Hapus
	/* Route::get('rawat-inap/edit-tindakan/{folio_id}', 'RawatinapController@editTindakan');
	Route::post('/rawat-inap/save-edit-tindakan/', 'RawatinapController@saveEditTindakan'); */
	Route::get('rawat-inap/hapus-tindakan/{id}/{registrasi_id}', 'RawatinapController@hapusTindakan');

	Route::get('rawat-inap/getKategoriTarifID/{id}/{reg_id?}', 'RawatinapController@getTarif');
	//IBS
	Route::get('rawat-inap/ibs/{id}', 'RawatinapController@ibs');
	Route::post('rawat-inap/save-ibs', 'RawatinapController@saveibs');

	//LAB
	Route::get('rawat-inap/laboratorium/{id}', 'RawatinapController@laboratorium');
	Route::post('rawat-inap/simpan-laboratorium', 'RawatinapController@simpanLaboratorium');

	//RADIOLOGI
	Route::get('rawat-inap/radiologi/{id}', 'RawatinapController@radiologi');
	Route::post('rawat-inap/simpan-radiologi', 'RawatinapController@simpanRadiologi');

	//GIZI
	Route::get('rawat-inap/gizi/{id}', 'RawatinapController@gizi');
	Route::post('rawat-inap/simpan-gizi', 'RawatinapController@simpanGizi');

	//MUTASI
	Route::get('rawat-inap/mutasi/{id}', 'RawatinapController@mutasi');
	Route::post('rawat-inap/simpan-mutasi', 'RawatinapController@simpanMutasi');

	//PULANG
	Route::post('rawat-inap/pulang', 'RawatinapController@pulang');
	Route::get('rawat-inap/kosongkan-bed/{bed_id}/{registrasi_id}', 'RawatinapController@kosongkanBed');

	//FISIOTERAPI
	Route::get('rawat-inap/fisioterapi/{id}', 'RawatinapController@fisioterapi');

	//Admisi
	Route::get('admission', 'AdmissionController@index');
	Route::post('admission', 'AdmissionController@admissionByTanggal');
	Route::get('admission/proses/{id}', 'AdmissionController@proses');
	//Route::post('admission/proses/{id?}', 'AdmissionController@proses');

	//ANTRIAN
	Route::get('rawatinap', 'RawatinapController@index');
	Route::get('rawatinap/antrian/{id?}', 'RawatinapController@antrian');
	Route::post('rawatinap/save', 'RawatinapController@saveRawatInap');
	Route::get('rawat-inap/get-datareg/{registrasi_id}', 'RawatinapController@getdatareg');

	Route::get('getkamar/{id}', 'RawatinapController@getKamar');
	Route::get('getbed/{kelompokkelas_id}/{kelas_id}/{kamar_id}', 'RawatinapController@getBed');

	//EMR
	Route::get('rawatinap/emr', 'RawatinapController@emr');

	//LAPORAN
	Route::get('rawatinap/lap-pengunjung', 'RawatinapController@lap_pengunjung');
	Route::post('rawatinap/lap-pengunjung', 'RawatinapController@lap_pengunjung_byTanggal');
	Route::get('rawatinap/sensus-harian', 'RawatinapController@sensus_harian');
	Route::get('lap-irna-getkamar/{kelas_id?}', 'RawatinapController@lapirnagetkamar');

	//ASKEP
	Route::get('rawat-inap/askep', 'RawatinapController@askep');

});
Route::get('informasi-rawat-inap', 'RawatinapController@informasi_rawat');
Route::get('data-rawat-inap', 'RawatinapController@dataRawatInap');
Route::get('detail-data-rawat-inap/{registrasi_id}', 'RawatinapController@detailDataRawatInap');
Route::get('informasi-rincian-biaya/{registrasi_id}', 'RawatinapController@rincianBiaya');
Route::get('informasi-total-biaya/{registrasi_id}', 'RawatinapController@sisaTotalTagihan');
