<?php

Route::group(['middleware'=>['web','auth','role:rehabmedik|administrator']], function () {
    //tindakanIRJ
    Route::get('rehabmedik/tindakan-irj','RehabmedikController@tindakanIRJ');
    Route::post('rehabmedik/tindakan-irj','RehabmedikController@tindakanIRJByTanggal');
    Route::get('rehabmedik/entry-tindakan-irj/{idreg}/{idpasien}','RehabmedikController@entryTindakanIRJ');
    Route::post('rehabmedik/save-tindakan','RehabmedikController@saveTindakan');

    Route::get('rehabmedik/insert-kunjungan/{registrasi_id}/{pasien_id}','RehabmedikController@insertKunjungan');

    //tindakanIGD
    Route::get('rehabmedik/tindakan-ird','RehabmedikController@tindakanIRD');
    Route::post('rehabmedik/tindakan-ird','RehabmedikController@tindakanIRDByTanggal');

    //tindakanIRNA
    Route::get('rehabmedik/tindakan-irna','RehabmedikController@tindakanIRNA');
    Route::post('rehabmedik/tindakan-irna','RehabmedikController@tindakanIRNAByTanggal');
    Route::get('rehabmedik/entry-tindakan-irna/{idreg}/{idpasien}','RehabmedikController@entryTindakanIRNA');

    Route::view('rehabmedik/billing','rehabmedik.billing');
    Route::view('rehabmedik/template','rehabmediktemplate');
    Route::view('rehabmedik/hasil','rehabmedik.hasil');
    Route::view('rehabmedik/laporan','rehabmedik.laporan');

    Route::view('rehabmedik/template','rehabmedik.template');
    Route::view('rehabmedik/hasil-rehabmedik','rehabmedik.hasil_radiologi');

    Route::get('rehabmedik/laporan-kunjungan','RehabmedikController@lap_kunjungan');
    Route::post('rehabmedik/laporan-kunjungan','RehabmedikController@lap_kunjungan_by_request');

    //Transaksi Langsung
    Route::get('rehabmedik/transaksi-langsung','RehabmedikController@transaksiLangsung');
    Route::post('rehabmedik/simpan-transaksi-langsung','RehabmedikController@simpanTransaksiLangsung');
    Route::get('rehabmedik/entry-transaksi-langsung/{registrasi_id}','RehabmedikController@entryTindakanLangsung');

    //Hapus Tindakan
    Route::get('rehabmedik/hapus-tindakan/{id}/{registrasi_id}/{pasien_id}','RehabmedikController@hapusTindakan');

    //rekammedis pasien
   // Route::get('rehabmedik/rekammedispasien', 'RehabmedikController@indexrekammedispasien')->name('rekammedispasien');

    //Laporan
    Route::get('rehabmedik/RL2','RehabmedikController@rl2');
    Route::post('rehabmedik/RL2','RehabmedikController@rl2_byRequest');
    Route::get('RL2/data={rawat}/{tga}/{tgb}','RehabmedikController@rl2_data');
    



});
