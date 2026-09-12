<?php
Route::group(['middleware'=>['web','auth','role:administrator']], function () {
 Route::view('/direksi/laporan', 'direksi.laporan');
 Route::get('/direksi/laporan-kinerja', 'DireksiController@laporanKinerja');
 Route::post('/direksi/laporan-kinerja', 'DireksiController@laporanKinerjaByTanggal');

 Route::get('/direksi/laporan-tagihan', 'DireksiController@tagihan');
 Route::post('/direksi/laporan-tagihan', 'DireksiController@tagihan_byRequest');
 Route::get('/direksi/laporan-pendapatan', 'DireksiController@pendapatan');
 Route::post('/direksi/laporan-pendapatan', 'DireksiController@pendapatan_byRequest');
 Route::get('/direksi/laporan-penerimaan', 'DireksiController@penerimaan');
 Route::get('/direksi/laporan-pem-uang-muka', 'DireksiController@uangmuka');
 Route::post('/direksi/laporan-pem-uang-muka', 'DireksiController@uangmuka_byRequest');
 Route::get('/direksi/laporan-bridging-jkn', 'DireksiController@bridgingjkn');
 Route::get('/direksi/laporan-selisih-negatif', 'DireksiController@selisihnegatif');
 Route::get('/direksi/laporan-naik-kelas', 'DireksiController@naikkelas');
 Route::post('/direksi/laporan-naik-kelas', 'DireksiController@naikkelas_byRequest');
 //Kinerja Rawat Jalan
 Route::get('/direksi/kinerja-rawat-jalan', 'DireksiController@kinerjaRawatJalan');
 Route::post('/direksi/kinerja-rawat-jalan', 'DireksiController@kinerjaRawatJalanByDate');
 Route::get('/direksi/detail-kinerja-rawat-jalan/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatJalan');

 //Kinerja Rawat Darurat
 Route::get('/direksi/kinerja-rawat-darurat', 'DireksiController@kinerjaRawatDarurat');
 Route::post('/direksi/kinerja-rawat-darurat', 'DireksiController@kinerjaRawatDaruratByDate');
 Route::get('/direksi/detail-kinerja-rawat-darurat/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatDarurat');

 //Kinerja Rawat Inap
 Route::get('/direksi/kinerja-rawat-inap', 'DireksiController@kinerjaRawatInap');
 Route::post('/direksi/kinerja-rawat-inap', 'DireksiController@kinerjaRawatInapByDate');
 Route::get('/direksi/detail-kinerja-rawat-inap/{dokter_id}/{cara_bayar_id}/{mapping}', 'DireksiController@detailKinerjaRawatInap');

 //pendapatan
 Route::get('direksi/laporan-pendapatan1', 'KasirController@tutup_kasir1');
 Route::post('direksi/laporan-pendapatan1', 'KasirController@tutup_kasir_byRequest1');

 
});

Route::group(['middleware'=>['web','auth', 'role:administrator|kepegawaian']], function () {
    Route::view('/managemen/kepegawaian', 'managemen.kepegawaian');
   // managemen
 //kodebidang
 Route::get('/direksi/bidang', 'DireksiController@bidang')->name('bidang');
 Route::get('/direksi/kodebidang/createbidang', 'DireksiController@createbidang');
 Route::post('/direksi/kodebidang/storebidang', 'DireksiController@storebidang')->name('direksi/kodebidang.store');
 Route::get('/direksi/kodebidang/kode/{id}/edit', 'DireksiController@editbidang');
 Route::post('/direksi/kodebidang/kode/{id}/update', 'DireksiController@updatebidang')->name('direksi/kodebidang.update');
 Route::get('/direksi/kodebidang/kode/{id}/delete', 'DireksiController@delete');
 
 //kategori pegawai
 Route::get('/direksi/kategoripegawai', 'DireksiController@kategoripegawai')->name('kategoripegawai');
 Route::get('/direksi/kategoripegawai/createkategoripegawai', 'DireksiController@createkategoripegawai');
 Route::post('/direksi/kategoripegawai/storekategoripegawai', 'DireksiController@storekategoripegawai')->name('direksi/kategoripegawai.store');
 Route::get('/direksi/kategoripegawai/kode/{id}/edit', 'DireksiController@editkategoripegawai');
 Route::post('/direksi/kategoripegawai/kode/{id}/update', 'DireksiController@updatekategoripegawai')->name('direksi/kategoripegawai.update');
 Route::get('/direksi/kategoripegawai/kode/{id}/delete', 'DireksiController@deletekategoripegawai');
 
 //departemen
 Route::get('/direksi/departemen', 'DireksiController@departemen')->name('departemen');
 Route::get('/direksi/departemen/createdepartemen', 'DireksiController@createdepartemen');
 Route::post('/direksi/departemen/storedepartemen', 'DireksiController@storedepartemen')->name('direksi/departemen.store');
 Route::get('/direksi/departemen/kode/{id}/edit', 'DireksiController@editdepartemen');
 Route::post('/direksi/departemen/kode/{id}/update', 'DireksiController@updatedepartemen')->name('direksi/departemen.update');
 Route::get('/direksi/departemen/kode/{id}/delete', 'DireksiController@deletedepartemen');

 
 //Master Jabatan
 Route::get('/direksi/masterjabatan', 'DireksiController@masterjabatan')->name('masterjabatan');
 Route::get('/direksi/masterjabatan/createmasterjabatan', 'DireksiController@createmasterjabatan');
 Route::post('/direksi/masterjabatan/storemasterjabatan', 'DireksiController@storemasterjabatan')->name('direksi/masterjabatan.store');
 Route::get('/direksi/masterjabatan/kode/{id}/edit', 'DireksiController@editmasterjabatan');
 Route::post('/direksi/masterjabatan/kode/{id}/update', 'DireksiController@updatemasterjabatan')->name('direksi/masterjabatan.update');
 Route::get('/direksi/masterjabatan/kode/{id}/delete', 'DireksiController@deletemasterjabatan');

 //status KTP Pegawai
 Route::get('/direksi/statusktppegawai', 'DireksiController@statusktppegawai')->name('statusktppegawai');
 Route::get('/direksi/statusktppegawai/createstatusktppegawai', 'DireksiController@createstatusktppegawai');
 Route::post('/direksi/statusktppegawai/storestatusktppegawai', 'DireksiController@storestatusktppegawai')->name('direksi/statusktppegawai.store');
 Route::get('/direksi/statusktppegawai/kode/{id}/edit', 'DireksiController@editstatusktppegawai');
 Route::post('/direksi/statusktppegawai/kode/{id}/update', 'DireksiController@updatestatusktppegawai')->name('direksi/statusktppegawai.update');
 Route::get('/direksi/statusktppegawai/kode/{id}/delete', 'DireksiController@deletestatusktppegawai');

 //ktp Pegawai
 Route::get('/direksi/statusktppegawai', 'DireksiController@statusktppegawai')->name('statusktppegawai');
 Route::get('/direksi/statusktppegawai/createstatusktppegawai', 'DireksiController@createstatusktppegawai');
 Route::post('/direksi/statusktppegawai/storestatusktppegawai', 'DireksiController@storestatusktppegawai')->name('direksi/statusktppegawai.store');
 Route::get('/direksi/statusktppegawai/kode/{id}/edit', 'DireksiController@editstatusktppegawai');
 Route::post('/direksi/statusktppegawai/kode/{id}/update', 'DireksiController@updatestatusktppegawai')->name('direksi/statusktppegawai.update');
 Route::get('/direksi/statusktppegawai/kode/{id}/delete', 'DireksiController@deletestatusktppegawai');

 //status Pegawai
 Route::get('/direksi/statuspegawai', 'DireksiController@statuspegawai')->name('statuspegawai');
 Route::get('/direksi/statuspegawai/createstatuspegawai', 'DireksiController@createstatuspegawai');
 Route::post('/direksi/statuspegawai/storestatuspegawai', 'DireksiController@storestatuspegawai')->name('direksi/statuspegawai.store');
 Route::get('/direksi/statuspegawai/kode/{id}/edit', 'DireksiController@editstatuspegawai');
 Route::post('/direksi/statuspegawai/kode/{id}/update', 'DireksiController@updatestatuspegawai')->name('direksi/statuspegawai.update');
 Route::get('/direksi/statuspegawai/kode/{id}/delete', 'DireksiController@deletestatuspegawai');\

 //penggajian

 Route::get('/direksi/penggajian', 'DireksiController@penggajian')->name('penggajian');
 Route::get('/direksi/penggajian/kode/{id}/input', 'DireksiController@inputpenggajian');
 Route::post('/direksi/penggajian/kode/{id}/save', 'DireksiController@savepenggajian')->name('direksi/penggajian.save');
 Route::get('/direksi/penggajian/kode/{id}/edit', 'DireksiController@editpenggajian');
 Route::post('/direksi/penggajian/kode/{id}/update', 'DireksiController@updatepenggajian')->name('direksi/penggajian.update');
    // histori pegawai
  
   });