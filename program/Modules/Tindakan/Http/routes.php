<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'tindakan', 'namespace' => 'Modules\Tindakan\Http\Controllers'], function()
{
    //Rawat Jalan
    Route::get('/', 'TindakanController@index')->name('tindakan');
    Route::post('/', 'TindakanController@index_byTanggal')->name('tindakan');
    Route::get('/entry/{idreg}/{idpasien}', 'TindakanController@entry')->name('tindakan.entry');
    Route::post('/search', 'TindakanController@search')->name('tindakan.search');
    Route::post('/saveTindakan', 'TindakanController@saveTindakan')->name('tindakan.save');
    Route::get('/edit-tindakan/{folio_id}', 'TindakanController@editTindakan');
    Route::post('/save-edit-tindakan', 'TindakanController@saveEditTindakan');
    Route::post('/kondisiakhir', 'TindakanController@kondisi_akhir_pasien')->name('tindakan.kondisiakhir');
    Route::get('/ajax', 'TindakanController@view_ajax');
    Route::get('/data', 'TindakanController@namaTindakan')->name('tindakan.data');
    Route::get('/data/edit/{id}', 'TindakanController@editNamaTindakan');
    Route::get('/data/hapus/{id}', 'TindakanController@hapusNamaTindakan');
    Route::post('/data/simpan-tindakan', 'TindakanController@simpanNamaTindakan');

    Route::get('/get_histori_pemeriksaan_pasien/{id}', 'TindakanController@get_data_histori_pemeriksaan_pasien');
    
    //IGD
    Route::get('/igd', 'TindakanController@tindakanIGD')->name('tindakan.igd');
    Route::post('/igd', 'TindakanController@tindakanIGD_byTanggal')->name('tindakan.igd');
    Route::get('/ajaxigd', 'TindakanController@ajax_tindakanIGD');
    Route::get('/igd/ubah-status-ugd/{registrasi_id}/{status_ugd}', 'TindakanController@ubahStatusUGD');

    //Hapus Tindakan
    Route::get('/hapus-tindakan/{id}/{idreg}/{pasien_id}', 'TindakanController@hapusTindakan');
    Route::get('/hapus-tindakan/{id}/{idreg}/{pasien_id}/{order}', 'TindakanController@hapusTindakan');

    //Pilih Tarif Kategori
    Route::get('getTarif/{kategoritarif_id}', 'TindakanController@getTarif');

    //Verifikasi Tindakan
    Route::get('/verifikasi-rj', 'TindakanController@verifikasiRJ');
    Route::get('/detail-verifikasi-rj/{registrasi_id}', 'TindakanController@detailVerifikasiRJ');
    Route::post('/save-verifikasi-rj', 'TindakanController@saveVerifikasiRJ');
	
		//Order Lab/Rad
		Route::get('/order/laboratorium/{layanan}/{id}', 'TindakanController@laboratorium');
		Route::get('/order/radiologi/{layanan}/{id}', 'TindakanController@radiologi');
		Route::get('/order/penunjang/{penunjang}/{layanan}/{id}', 'TindakanController@penunjang');
		Route::post('/simpan-laboratorium', 'TindakanController@simpan_laboratorium');
		Route::post('/simpan-radiologi', 'TindakanController@simpan_radiologi');
		Route::post('/simpan-penunjang', 'TindakanController@simpan_penunjang');
});


Route::group(['middleware' => ['web','auth','role:dokter|adminpoli'], 'prefix' => 'tindakan', 'namespace' => 'Modules\Tindakan\Http\Controllers'], function()
{
    //tindakan dokter
    Route::get('/dokter', 'TindakanController@index_dokter')->name('tindakan_dokter');
    Route::get('/entry_dokter/{idreg}/{idpasien}', 'TindakanController@entry_dokter')->name('tindakan.entry_dokter');
    Route::post('/simpan-pemeriksaan-object', 'TindakanController@simpan_pemeriksaan_object');
    Route::get('/list-pemeriksaan-object/{id}', 'TindakanController@list_pemeriksaan_object');
    Route::get('/hapus-pemeriksaan-object/{id}', 'TindakanController@hapus_pemeriksaan_object');
    Route::post('/kondisiakhir', 'TindakanController@kondisi_akhir_pasien')->name('tindakan.kondisiakhir');
    Route::post('/cek_pembayaran', 'TindakanController@cek_pembayaran')->name('tindakan.cekpembayaran');
    Route::post('/cek_pembayaran/{id}', 'TindakanController@cek_pembayaran')->name('tindakan.cekpembayaran');
    Route::get('/get_data_biaya/{id}', 'TindakanController@get_data_biaya');
    Route::get('/get_data_biaya_obat/{id}', 'TindakanController@get_data_biaya_obat');
    Route::get('/get_data_biaya_pemakaian_obat/{id}', 'TindakanController@get_data_biaya_pemakaian_obat');
    Route::get('/get_total_biaya/{id}', 'TindakanController@get_total_biaya');
    Route::post('/update-saran-dokter', 'TindakanController@update_saran_dokter');
    //Route::get('/get-data-histori-alergi','AlergiController@get_data_histori_alergi');
});
