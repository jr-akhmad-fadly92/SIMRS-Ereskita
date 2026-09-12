<?php
Route::group(['middleware' => ['web', 'auth','role:administrator']], function () {
//V-CLAIM
Route::get('frontoffice/v-claim/dpjp', 'FrontofficeController@vclaimDpjp');
Route::get('frontoffice/v-claim/peserta', 'FrontofficeController@vclaimPeserta');
Route::post('frontoffice/v-claim/peserta', 'FrontofficeController@vclaimPesertaPost');
Route::get('frontoffice/v-claim/sep-rj', 'FrontofficeController@vclaimSep');
Route::post('frontoffice/v-claim/sep-rj', 'FrontofficeController@vclaimSepPost');
Route::get('frontoffice/v-claim/sep-ri', 'FrontofficeController@vclaimSepRanap');
Route::post('frontoffice/v-claim/sep-ri', 'FrontofficeController@vclaimSepPost');
Route::post('frontoffice/v-claim/kirim-lpk/{no_sep}', 'SepController@kirimLpk');
//E-CLAIM
Route::get('frontoffice/e-claim/rawat-jalan', 'FrontofficeController@data_rawatJalan');
Route::post('frontoffice/e-claim/rawat-jalan', 'FrontofficeController@data_rawatJalan_byTanggal');
Route::get('frontoffice/e-claim/rawat-inap', 'FrontofficeController@data_rawatInap');
Route::post('frontoffice/e-claim/rawat-inap', 'FrontofficeController@data_rawatInap_byTanggal');
Route::get('frontoffice/e-claim/bridging/{registrasi_id}', 'FrontofficeController@bridging');
Route::get('frontoffice/e-claim/get_dataRawatJalan', 'FrontofficeController@get_data_rawatJalan');
Route::get('frontoffice/e-claim/cetak-eklaim/{no_sep}', 'FrontofficeController@cetakEklaim');
Route::get('frontoffice/e-claim/bridging-irna/{registrasi_id}', 'FrontofficeController@bridging');
Route::get('frontoffice/e-claim/get-icd9-data', 'FrontofficeController@geticd9data');
Route::get('frontoffice/e-claim/get-icd10-data', 'FrontofficeController@geticd10data');

Route::get('frontoffice/e-claim/bridging-rincian-biaya/{registrasi_id}', 'FrontofficeController@rincianBiaya');
//INPUT DIAGNOSA
Route::get('frontoffice/input_diagnosa_rawatjalan', 'FrontofficeController@input_diagnosa_rawatjalan');
Route::post('frontoffice/input_diagnosa_rawatjalan', 'FrontofficeController@input_diagnosa_rawatjalan_byTanggal');
Route::get('frontoffice/lap-rekammedis', 'FrontofficeController@rekammedis_pasien');
Route::get('frontoffice/input_diagnosa_rawatinap', 'FrontofficeController@input_diagnosa_rawatinap');
Route::post('frontoffice/input_diagnosa_rawatinap', 'FrontofficeController@input_diagnosa_rawatinap_byTanggal');
//Route::get('frontoffice/form_input_diagnosa_rawatjalan/{id?}', 'FrontofficeController@form_input_diagnosa_rawatjalan');
//Route::get('frontoffice/form_input_diagnosa_rawatinap/{id?}', 'FrontofficeController@form_input_diagnosa_rawatinap');
//Route::post('frontoffice/simpan_diagnosa_rawatjalan', 'FrontofficeController@simpan_diagnosa_rawatjalan');
//Route::post('frontoffice/simpan_diagnosa_rawatinap', 'FrontofficeController@simpan_diagnosa_rawatinap');
Route::get('frontoffice/form-input-diagnosa/{id?}', 'FrontofficeController@form_input_diagnosa');
Route::post('frontoffice/simpan-diagnosa', 'FrontofficeController@simpan_diagnosa');
Route::post('frontoffice/update-kondisi', 'FrontofficeController@updateKondisi');
Route::post('frontoffice/update-kasus', 'FrontofficeController@updateKasus');
Route::post('frontoffice/update-gpa', 'FrontofficeController@updateGpa');
Route::post('frontoffice/update-keterangan', 'FrontofficeController@updateKeterangan');
Route::post('frontoffice/update-kematian', 'FrontofficeController@updateKematian');
//Hapus diagnosa dan Prosedur
Route::get('frontoffice/hapus-diagnosa/{id}/{registrasi_id}', 'FrontofficeController@hapusDiagnosa');
Route::get('frontoffice/hapus-prosedur/{id}/{registrasi_id}', 'FrontofficeController@hapusProsedur');

});
Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/frontoffice/lap-rekammedis/datapasien', 'FrontofficeController@datapasien');
	Route::view('frontoffice/antrian-rawat-jalan', 'frontoffice.antrian-rawat-jalan');
	Route::view('frontoffice/laporan', 'frontoffice.laporan');
	Route::view('frontoffice/rawat-darurat', 'frontoffice.rawat-darurat');
	Route::view('frontoffice/rawat-inap', 'frontoffice.rawat-inap');
	Route::view('frontoffice/rawat-jalan', 'frontoffice.rawat-jalan');
	Route::view('frontoffice/daftar-bayi', 'frontoffice.rawat-darurat');
	Route::view('frontoffice/supervisor', 'frontoffice.supervisor');
	Route::view('frontoffice/rekammedis', 'frontoffice.rekammedis');
	Route::view('frontoffice/rekammedis/laporan', 'frontoffice.laporanrekammedis');

	//CETAK
	Route::get('frontoffice/cetak', 'FrontofficeController@cetak');
	Route::post('frontoffice/cetak', 'FrontofficeController@cetak_byTanggal');
	Route::get('frontoffice/cetak-ajax', 'FrontofficeController@ajax_cetak');
	Route::get('frontoffice/cetak_barcode', 'FrontofficeController@dataCetakBarcode');
	Route::get('frontoffice/cetak_barcode/{id}/{reg_id}', 'FrontofficeController@cetak_barcode');
	Route::get('frontoffice/cetak_antrian/{id}/{reg_id}', 'FrontofficeController@cetak_antrian');
	Route::get('frontoffice/cetak_kib/{status}/{id}', 'FrontofficeController@cetak_kib');
	Route::get('frontoffice/cetak_gelang/{id}', 'FrontofficeController@cetak_gelang');
	Route::get('frontoffice/cetak-perjanjian', 'FrontofficeController@cetakPerjanjian');
	Route::get('frontoffice/cetak-kiup/{id}', 'FrontofficeController@cetakKIUP');

	//LAPORAN
	Route::get('frontoffice/laporan/dokter', 'FrontofficeController@lap_dokter');
	Route::get('frontoffice/laporan/pengunjung', 'FrontofficeController@lap_pengunjung');
	Route::post('frontoffice/laporan/pengunjung', 'FrontofficeController@lap_pengunjung_bytanggal');
	Route::get('frontoffice/laporan/kunjungan', 'FrontofficeController@lap_kunjungan');
	Route::post('frontoffice/laporan/kunjungan', 'FrontofficeController@lap_kunjungan_byTanggal');
	Route::get('frontoffice/laporan/diagnosa-irj', 'FrontofficeController@lap_diagnosa_irj');
	Route::post('frontoffice/laporan/diagnosa-irj', 'FrontofficeController@lap_diagnosa_irj_byTanggal');
	Route::get('frontoffice/laporan/diagnosa-irna', 'FrontofficeController@lap_diagnosa_irna');
	Route::post('frontoffice/laporan/diagnosa-irna', 'FrontofficeController@lap_diagnosa_irna_byTanggal');
	Route::get('frontoffice/laporan/rekammedis-pasien', 'FrontofficeController@rekammedis_pasien');
	Route::post('frontoffice/laporan/rekammedis-pasien', 'FrontofficeController@view_rekammedis_pasien');
	Route::get('frontoffice/laporan/pengunjung-ajax', 'FrontofficeController@ajax_lap_pengunjung');

	//SUPERVISOR
	Route::get('frontoffice/supervisor/ubahdpjp', 'FrontofficeController@ubah_dpjp');
	Route::get('frontoffice-data-ubah-dpjp', 'FrontofficeController@dataUbahDpjp');
	Route::get('frontoffice-data-ubah-dpjp/{tga?}/{tgb?}', 'FrontofficeController@dataUbahDpjp');
	Route::get('frontoffice-data-detail-reg/{id}', 'FrontofficeController@dataReg');
	Route::post('frontoffice/supervisor/saveubahdpjp', 'FrontofficeController@save_ubahdpjp');

	Route::get('frontoffice/supervisor/hapusregistrasi/{tanggal?}', 'FrontofficeController@hapusRegistrasi');
	Route::get('frontoffice/supervisor/save-hapus-registrasi/{id}', 'FrontofficeController@saveHapusRegistrasi');
	Route::post('frontoffice/supervisor/registrasibytanggal', 'FrontofficeController@registrasiByTanggal');

	

	//Tracer
	Route::get('frontoffice/tracer', 'FrontofficeController@tracer');
	Route::get('frontoffice/data-tracer/{poli_id?}/{tgl?}', 'FrontofficeController@dataTracer');
	Route::get('frontoffice/cetak-tracer/{registrasi_id}', 'FrontofficeController@cetakTracer');
	Route::get('frontoffice/tracerAll', 'FrontofficeController@tracerAll');
	Route::get('frontoffice/cetakTracerAll', 'FrontofficeController@cetakTracerAll');

	//Setting Kuota Poli
	Route::get('frontoffice/setting-kuota-poli', 'FrontofficeController@settingKuotaPoli');
	Route::get('frontoffice/get-poli/{id}', 'FrontofficeController@getPoli');
	Route::post('frontoffice/save-kuota-poli', 'FrontofficeController@saveKuotaPoli');

	//Out Gate
	Route::get('frontoffice/outgate', 'FrontofficeController@outgate');
	Route::post('frontoffice/outgate', 'FrontofficeController@outgateViewData');

	//In Guide
	Route::get('frontoffice/inguide', 'FrontofficeController@inguide');
	Route::post('frontoffice/inguide', 'FrontofficeController@inguideViewData');

	//Cetak SEP OTOMATIS
	Route::get('frontoffice/data-sep', 'FrontofficeController@dataSEP');
	Route::get('frontoffice/cetak-sep', 'FrontofficeController@cetakSEP');
	Route::get('frontoffice/data-sep2', 'FrontofficeController@dataSEP2');
	Route::get('frontoffice/cetak-sep2', 'FrontofficeController@cetakSEP2');

	//Histori Pasien
	Route::get('frontoffice/histori-pasien/{pasien_id}', 'FrontofficeController@historiPasien');
	Route::post('frontoffice/histori-pasien', 'FrontofficeController@historiPasienByRequest');

	//Ubah Status Pelayanan
	Route::get('get-data-registrasi/{registrasi_id}', 'FrontofficeController@getDataRegistrasi');
	Route::post('ubah-status-pelayanan/', 'FrontofficeController@ubahStatusPelayanan');

	//Ubah Status Pelayanan
	Route::get('/frontoffice/set-cara-bayar', 'FrontofficeController@setCarabayar');
	Route::get('/frontoffice/set-bangsal-folio', 'FrontofficeController@setBangsalFolio');
});
