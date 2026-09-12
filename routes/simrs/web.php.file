<?php

Auth::routes();

Route::get('/', 'IndexController@index')->name('index');
// ANTRIAN RJ
Route::get('/guest/antrian', 'GuestController@touch')->name('antrian');
Route::post('/guest/savetouch', 'GuestController@savetouch')->name('antrian.savetouch');
Route::get('/guest/layarlcd', 'GuestController@layarlcd')->name('antrian.layarlcd');
Route::get('/guest/layarlcd-poli', 'GuestController@layarlcdPoli')->name('antrian.layarlcd');
Route::get('/guest/layarantrian', 'GuestController@layarantrian')->name('antrian.layarantrian');
Route::get('/guest/layarantrian-polia', 'GuestController@layarantrianPolia');
Route::get('/guest/layarantrian-polib', 'GuestController@layarantrianPolib');
Route::get('/guest/suara', 'GuestController@suara')->name('antrian.suara');
Route::get('/guest/datalayarlcd/{loket}', 'GuestController@datalayarlcd')->name('antrian.datalayarlcd');
// ANTRIAN APOTEK
Route::get('/guest/nomor-antrian-apotek', 'GuestController@touchApotek')->name('antrian-apotek');
Route::get('/guest/layarlcd-apotek', 'GuestController@layarlcdApotek');
Route::get('/guest/suara-apotek', 'GuestController@suaraApotek')->name('antrian.suara-apotek');
Route::get('/guest/layarantrian-apotek', 'GuestController@layarantrianApotek');
Route::get('/guest/datalayarlcd-apotek/{loket}', 'GuestController@datalayarlcdApotek')->name('antrian.datalayarlcd-apotek');
Route::post('/guest/savetouch-apotek', 'GuestController@savetouchApotek')->name('antrian.savetouch-apotek');
// BED
Route::get('/guest/display-bed', 'GuestController@display_bed');


Route::get('/home', 'HomeController@index')->name('dashboard');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/notifikasi', 'HomeController@notifikasi')->name('notifikasi');

Route::group(['middleware'=>['web','auth']], function () {
  // folder simrs ==========================================
  include __DIR__ .'/simrs/kasir.php';
  include __DIR__ .'/simrs/kontrolpanel.php';
  include __DIR__ .'/simrs/import.php';
 
  include __DIR__ .'/simrs/frontoffice.php';
  include __DIR__ .'/simrs/igd.php';
  include __DIR__ .'/simrs/rawatjalan.php';
  include __DIR__ .'/simrs/antrian.php';
  include __DIR__ .'/simrs/farmasi.php';
  include __DIR__ .'/simrs/rawatinap.php';
  include __DIR__ .'/simrs/operasi.php';
  include __DIR__ .'/simrs/radiologi.php';
  include __DIR__ .'/simrs/laboratorium.php';
  include __DIR__ .'/simrs/penunjang.php';
  include __DIR__ .'/simrs/tahuntarif.php';
  include __DIR__ .'/simrs/biayaregistrasi.php';
  include __DIR__ .'/simrs/dokter.php';
  include __DIR__ .'/simrs/pemeriksaanlab.php';
  include __DIR__ .'/simrs/penjualan.php';
  include __DIR__ .'/simrs/masterobat.php';
  include __DIR__ .'/simrs/mastersplit.php';
  include __DIR__ .'/simrs/regperjanjian.php';
  include __DIR__ .'/simrs/bridging.php';
  include __DIR__ .'/simrs/fasilitas.php';
  include __DIR__ .'/simrs/gizi.php';
  include __DIR__ .'/simrs/slideshow.php';
  include __DIR__ .'/simrs/sep.php';
  include __DIR__ .'/simrs/direksi.php';
  include __DIR__ .'/simrs/inacbg.php';
  include __DIR__ .'/simrs/mastermapping.php';
  include __DIR__ .'/simrs/mapping.php';
  include __DIR__ .'/simrs/kelompokkelas.php';
  include __DIR__ .'/simrs/mapping_biaya.php';
  include __DIR__ .'/simrs/managemen.php';
  // folder logistik =================================================
  include __DIR__ .'/logistik/backoffice.php';
  include __DIR__ .'/logistik/logistik.php';
  include __DIR__ .'/logistik/master_item.php';
  include __DIR__ .'/logistik/laporan.php';
  
  // lain lain =======================================================

  Route::resource('jadwal-dokter', 'JadwaldokterController');
  Route::get('datatablejadwaldokter', 'JadwaldokterController@getData');
  Route::get('hapus-jadwal/{id}', 'JadwaldokterController@hapusJadwal');
});
