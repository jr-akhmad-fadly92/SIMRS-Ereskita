<?php
Route::group(['middleware'=>['web','auth','role:verifikator|supervisor|kasir|administrator']], function () {
  Route::get('kasir/bayar/{reg_id}/{pasien_id}', 'KasirController@kasirBayar');
  Route::post('kasir/save-bayar', 'KasirController@saveBayar');
	
  Route::get('kasir/rawatjalan', 'KasirController@rawat_jalan')->name('kasir.rawatjalan');
  Route::post('kasir/rawatjalan', 'KasirController@rawatjalanByTanggal')->name('kasir.rawatjalan');
  Route::get('kasir/rawatjalan-ajax', 'KasirController@ajax_rawat_jalan')->name('kasir.rawatjalan-ajax');
  Route::post('kasir/rawatjalan/bytanggal', 'KasirController@byTanggal');
  Route::post('kasir/rawatjalan/byrm', 'KasirController@byRM');
  Route::get('kasir/rawatjalan/bayar/{reg_id}/{pasien_id}', 'KasirController@bayar_rawat_jalan');
  Route::post('kasir/rawatjalan/save_bayar_rawat_jalan', 'KasirController@save_bayar_rawat_jalan')->name('kasir.save_bayar_rawat_jalan');
  Route::get('kasir/cetak', 'KasirController@cetak');
  Route::post('kasir/cetak', 'KasirController@cetakByTanggal');
  Route::get('kasir/cetak/cetakkuitansi/{id}', 'KasirController@cetakkuitansi');
  Route::get('kasir/cetakkuitansi/{id}', 'KasirController@cetak_kuitansi_langsung');
  Route::get('kasir/rincian-biaya/{id}', 'KasirController@cetak_RincianBiaya');

  Route::get('kasir/piutang/{registrasi_id}', 'KasirController@piutang');
  Route::get('kasir/piutang-igd/{registrasi_id}', 'KasirController@piutangIgd');

  //Kasir IGD
  Route::get('kasir/igd', 'KasirController@igd')->name('kasir.igd');
  Route::post('kasir/igd', 'KasirController@igdByTanggal')->name('kasir.igd');
  Route::get('kasir/ajax-igd', 'KasirController@ajax_igd')->name('kasir.ajax-igd');

  //Rawat Inap
  Route::get('kasir/rawatinap', 'KasirController@rawat_inap')->name('kasir.rawatinap');
  Route::post('kasir/rawatinap', 'KasirController@rawat_inap_byTanggal');
  Route::get('kasir/rawatinap/bayar/{reg_id}/{pasien_id}', 'KasirController@bayar_rawat_inap');
  Route::post('kasir/rawatinap/save_bayar_rawat_inap', 'KasirController@save_bayar_rawat_inap');
  Route::get('kasir/cetakkuitansi_irna/{id}', 'KasirController@cetak_kuitansi_langsung_irna');
  
  Route::get('kasir/batal-pulang/{registrasi_id}', 'KasirController@batalPulang');

  Route::get('kasir/detail-verifikasi/{registrasi_id}', 'KasirController@detailVerifikasi');
  Route::get('kasir/detail-tindakan-verifikasi/{registrasi_id}/{tarif_id}', 'KasirController@detailTindakanVerifikasi');

  Route::post('kasir/ubah-tipe-jkn', 'KasirController@ubahTipeJKN');
  Route::post('kasir/save-tindakan', 'KasirController@save_tindakan');

  //Uang Muka
  Route::get('kasir/data-pasien', 'KasirController@dataPasien');
  Route::get('kasir/uang-titipan', 'KasirController@uangtitipan');
  Route::post('kasir/uang-titipan', 'KasirController@uangtitipan_byPasien');
  Route::post('kasir/save-uang-titipan', 'KasirController@save_uangtitipan');
  Route::get('kasir/cetak-kwitansi-uang-titipan/{id_um}', 'KasirController@cetak_uangtitipan');
  Route::get('kasir/hapus-uang-titipan/{id_um}', 'KasirController@hapus_uangtitipan');

  Route::get('kasir/tutup-transaksi', 'KasirController@tutup_transaksi');

  //Lain - lain
  Route::get('kasir/lain-lain', 'KasirController@transaksi_lain_lain');
  Route::get('kasir/lain-lain/bayar/{registrasi_id?}', 'KasirController@form_bayar_lain_lain');
  Route::post('kasir/rawatinap/save_bayar_lain_lain', 'KasirController@save_bayar_lain_lain');
  Route::get('kasir/cetakkuitansibebas/{id}', 'KasirController@cetak_kuitansi_bebas');

  //SUPERVISOR
  Route::get('kasir/edit-transaksi', 'KasirController@edit_transaksi');
  Route::get('kasir/batal-bayar', 'KasirController@batal_bayar');
  Route::post('kasir/batal-bayar', 'KasirController@batal_bayar_byTanggal');
  Route::get('kasir/rincian-bayar/{registrasi_id}', 'KasirController@rincian_pembayaran');
  Route::get('kasir/save-batal-bayar/{registrasi_id}', 'KasirController@save_pembatalan');
  Route::get('kasir/batal-piutang', 'KasirController@batal_piutang');

  //LAPORAN
  Route::get('kasir/laporan-rincian-detail-tindakan', 'KasirController@lap_detail_tindakan');
  Route::post('kasir/laporan-rincian-detail-tindakan', 'KasirController@lap_detail_tindakanByFilter');
  Route::get('kasir/laporan-penerimaan-tunai', 'KasirController@lap_penerimaan_tunai');
  Route::post('kasir/laporan-penerimaan-tunai', 'KasirController@lap_penerimaan_tunai_byTanggal');
  Route::get('kasir/tutup-kasir', 'KasirController@tutup_kasir');
  Route::post('kasir/tutup-kasir', 'KasirController@tutup_kasir_byRequest');

  Route::view('kasir/transaksi', 'kasir.transaksi');
  Route::view('kasir/supervisor', 'kasir.supervisor');
  Route::view('kasir/laporan', 'kasir.laporan');

  //Get Tarif
  Route::get('kasir/gettarif/{kat_id}', 'KasirController@getTarif');

  //verifikasi Kasa
  Route::get('kasir/verifikasi-kasa', 'KasirController@verifikasiKasa');
  Route::post('kasir/verifikasi-kasa', 'KasirController@verifikasiKasaByRequest');
  Route::get('kasir/detail-verifikasi-kasa/{registrasi_id}', 'KasirController@detailVerifikasiKasa');
  Route::post('kasir/save-verifikasi-kasa', 'KasirController@saveVerifikasiKasa');
  //Tambah Tindakan
  Route::get('kasir/tambah-tindakan/{registrasi_id}', 'KasirController@tambahTindakan');
  Route::post('/kasir/save-tambah-tindakan/', 'KasirController@saveTindakan');
  
  //Cetak
  Route::get('kasir/cetak-verifikasi/{registrasi_id}', 'KasirController@cetakVerifikasi');

  //Kosongkan Bed
  Route::get('kasir/kosongkan-bed/{reg_id}/{pasien_id}', 'KasirController@kosongkanBed');

  //Verifikasi IRNA
  Route::get('kasir/verifikasi', 'KasirController@verifikasi');
  Route::post('kasir/verifikasi', 'KasirController@getDataVerifInap');
  Route::get('kasir/verifikasi-get-data', 'KasirController@getDataVerifikasi');

  Route::post('kasir/verifikasi-kasir-irna/', 'KasirController@verifikasirKasirIrna');
  Route::post('kasir/verifikasi-detail-kasir-irna', 'KasirController@verifikasirDetailKasirIrna');
  Route::get('kasir/unverifikasi-kasir-irna/{folio_id}/{registrasi_id}', 'KasirController@unverifikasiKasirIrna');
  Route::get('kasir/hapus-tindakan-irna/{folio_id}/{registrasi_id}', 'KasirController@hapusTindakanIrna');

  //Keuangan
  Route::get('kasir/keuangan', 'KasirController@keuangan')->name('kasir.keuangan');

  //Akun Keuangan
  Route::get('/kasir/keuangan/akun','KasirController@akunkeuangan')->name('akunkeuangan');
  Route::get('/kasir/keuangan/createakunkeuangan', 'KasirController@createakunkeuangan');
  Route::post('/kasir/keuangan/storeakunkeuangan', 'KasirController@storeakunkeuangan')->name('keuangan/akunkeuangan.store');
  Route::get('/kasir/keuangan/kode/{id}/edit', 'KasirController@editakunkeuangan');
  Route::post('/kasir/keuangan/kode/{id}/update', 'KasirController@updateakunkeuangan')->name('keuangan/akunkeuangan.update');
  Route::get('/kasir/keuangan/kode/{id}/delete', 'KasirController@deleteakunkeuangan');

});
