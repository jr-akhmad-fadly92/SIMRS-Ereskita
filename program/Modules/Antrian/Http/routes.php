<?php
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'antrian', 'namespace' => 'Modules\Antrian\Http\Controllers'], function(){
	// Route::get('/', 'AntrianController@touch')->name('antrian');
	// Route::post('/savetouch', 'AntrianController@savetouch')->name('antrian.savetouch');
	// Route::get('/layarlcd', 'AntrianController@layarlcd')->name('antrian.layarlcd');
	// Route::get('/layarantrian', 'AntrianController@layarantrian')->name('antrian.layarantrian');
	// Route::get('/suara', 'AntrianController@suara')->name('antrian.suara');
	// Route::get('/datalayarlcd/{loket}', 'AntrianController@datalayarlcd')->name('antrian.datalayarlcd');
	Route::get('/daftarpanggil/{loket}', 'AntrianController@daftarpanggil')->name('antrian.daftarpanggil'); //Data
	Route::get('/daftarantrian/{loket}', 'AntrianController@daftarantrian')->name('antrian.daftarantrian'); //Halaman Daftar Antrian
	Route::post('/panggil', 'AntrianController@panggil')->name('antrian.panggil');
	Route::post('/panggilkembali', 'AntrianController@panggilkembali')->name('antrian.panggilkembali');
	Route::post('/poli', 'AntrianController@poli');
	Route::get('/registrasi/{id}/{jenis?}', 'AntrianController@registrasi');
	Route::get('/reg_pasienlama/{id}/{jenis?}', 'AntrianController@reg_pasienlama');
	Route::get('/reg_blmterdata/{id}/{jenis?}', 'AntrianController@reg_blm_terdata');
	
	// Route::get('/nomor-antrian-apotek', 'AntrianController@touchApotek')->name('antrian-apotek');
	// Route::get('/layarlcd-apotek', 'AntrianController@layarlcdApotek');
	// Route::get('/suara-apotek', 'AntrianController@suaraApotek')->name('antrian.suara-apotek');
	// Route::get('/layarantrian-apotek', 'AntrianController@layarantrianApotek');
	// Route::get('/datalayarlcd-apotek/{loket}', 'AntrianController@datalayarlcdApotek')->name('antrian.datalayarlcd-apotek');
	// Route::post('/savetouch-apotek', 'AntrianController@savetouchApotek')->name('antrian.savetouch-apotek');
	Route::get('/daftarpanggil-apotek/{loket}', 'AntrianController@daftarpanggilApotek')->name('antrian.daftarpanggil-apotek');
	Route::get('/daftarantrian-apotek/{loket}', 'AntrianController@daftarantrianApotek')->name('antrian.daftarantrian-apotek');
	Route::post('/panggil-apotek', 'AntrianController@panggilApotek')->name('antrian.panggil-apotek');
	Route::post('/panggilkembali-apotek', 'AntrianController@panggilkembaliApotek')->name('antrian.panggilkembali-apotek');
	
	// ANTRIAN FARMASI
	Route::get('/farmasi', 'AntrianController@antrianFarmasi');
	
});
