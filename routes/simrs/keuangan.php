<?php

Route::group(['middleware'=>['web','auth','role:verifikator|supervisor|kasir|administrator']], function () {

  //Keuangan

  Route::get('kasir/keuangan', 'KasirController@keuangan')->name('kasir.keuangan');



  //Akun Keuangan

  Route::get('/keuangan/akun','KasirController@akunkeuangan')->name('akunkeuangan');

  Route::get('/keuangan/createakunkeuangan', 'KasirController@createakunkeuangan');

  Route::post('/keuangan/storeakunkeuangan', 'KasirController@storeakunkeuangan')->name('keuangan/akunkeuangan.store');

  Route::get('/keuangan/kode/{id}/edit', 'KasirController@editakunkeuangan');

  Route::post('keuangan/kode/{id}/update', 'KasirController@updateakunkeuangan')->name('keuangan/akunkeuangan.update');

  Route::get('keuangan/kode/{id}/delete', 'KasirController@deleteakunkeuangan');

  // Jurnal Keuangan

  Route::get('/keuangan/jurnal','KeuanganController@jurnal')->name('jurnal');

  Route::get('/keuangan/input-jurnal','KeuanganController@inputjurnal')->name('input-jurnal');

  Route::post('/keuangan/store-jurnal','KeuanganController@storejurnal')->name('store-jurnal');

  Route::get('/keuangan/list-jurnal-bulan-ini','KeuanganController@listjurnal');

  Route::get('/keuangan/hapus-list-jurnal-bulan-ini/{id}','KeuanganController@hapuslistjurnal');

  // Jurnal harian

  Route::get('/keuangan/jurnal-umum','KeuanganController@jurnal_umum');

  Route::post('/keuangan/jurnal-umum','KeuanganController@jurnal_umum_request');

  Route::get('/keuangan/jurnal-umum/{id}','KeuanganController@jurnal_umum_bulan');

  Route::get('/keuangan/list-detail-jurnal/{id}','KeuanganController@listjurnaldetail');

  Route::get('/keuangan/hapus-list-detail-jurnal/{id}','KeuanganController@hapuslistjurnaldetail');

  // buku besar

  Route::get('/keuangan/buku-besar','KeuanganController@bukubesar');

  Route::get('/keuangan/buku-besar/{id}','KeuanganController@pilihakun');

  Route::post('/keuangan/buku-besar/{id}','KeuanganController@pilihakun_request');

  Route::get('/keuangan/buku-besar/detail/{id}/{akun}','KeuanganController@detailakun_bukubesar');

  Route::get('/keuangan/list-detail-akun/{id}/{akun}','KeuanganController@listakundetail');

  Route::get('/keuangan/hapus-list-detail-akun/{id}','KeuanganController@hapuslistakundetail');

  //neraca

  Route::get('/keuangan/neraca','KeuanganController@neraca');

  Route::post('/keuangan/neraca','KeuanganController@neraca_request');

  Route::get('/keuangan/neraca/{id}','KeuanganController@neraca_bulan');

  Route::get('/keuangan/list-detail-neraca-aktiva-lancar/{id}','KeuanganController@listneracadetail_lancar');

  Route::get('/keuangan/list-detail-neraca-aktiva-tetap/{id}','KeuanganController@listneracadetail_tetap');


});

