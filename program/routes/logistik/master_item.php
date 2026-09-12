<?php
Route::group(['middleware'=>['web','auth','role:administrator|logistik']], function () {
 
  Route::get('/backoffice','BackofficeController@index');
  Route::get('/backoffice/master','BackofficeController@indexmaster');
  //master ruangan =============================================================================================
  Route::get('/backoffice/master_ruangan', 'BackofficeController@masterruangan');
  Route::get('/backoffice/master_ruangan/createruangan', 'BackofficeController@createmasterruangan');
  Route::post('/backoffice/master_ruangan/storeruangan', 'BackofficeController@storemasterruangan')->name('backoffice/masterruangan.store');
  Route::get('/backoffice/master_ruangan/kode/{id}/edit', 'BackofficeController@editmasterruangan');
  Route::post('/backoffice/master_ruangan/kode/{id}/update', 'BackofficeController@updatemasterruangan')->name('backoffice/masterruangan.update');
  Route::get('/backoffice/master_ruangan/kode/{id}/delete', 'BackofficeController@deletemasterruangan');
  ///master jenis barang ======================================================================================
  Route::get('/backoffice/master_jenis_barang', 'BackofficeController@masterjenisbarang');
  Route::get('/backoffice/master_jenis_barang/createjenisbarang', 'BackofficeController@createmasterjenisbarang');
  Route::post('/backoffice/master_jenis_barang/storejenisbarang', 'BackofficeController@storemasterjenisbarang')->name('backoffice/masterjenisbarang.store');
  Route::get('/backoffice/master_jenis_barang/kode/{id}/edit', 'BackofficeController@editmasterjenisbarang');
  Route::post('/backoffice/master_jenis_barang/kode/{id}/update', 'BackofficeController@updatemasterjenisbarang')->name('backoffice/masterjenisbarang.update');
  Route::get('/backoffice/master_jenis_barang/kode/{id}/delete', 'BackofficeController@deletemasterjenisbarang');
  //master lokasi ruangan =====================================================================================
  Route::get('/backoffice/master_lokasi_barang', 'BackofficeController@masterlokasibarang');
  Route::get('/backoffice/master_lokasi_barang/createlokasi', 'BackofficeController@createmasterlokasibarang');
  Route::post('/backoffice/master_lokasi_barang/storelokasi', 'BackofficeController@storemasterlokasibarang')->name('backoffice/masterlokasibarang.store');
  Route::get('/backoffice/master_lokasi_barang/kode/{id}/edit', 'BackofficeController@editmasterlokasibarang');
  Route::post('/backoffice/master_lokasi_barang/kode/{id}/update', 'BackofficeController@updatemasterlokasibarang')->name('backoffice/masterlokasibarang.update');
  Route::get('/backoffice/master_lokasi_barang/kode/{id}/delete', 'BackofficeController@deletemasterlokasibarang');
  //master Produsen / Supplier =====================================================================================
  Route::get('/backoffice/produsen-supplier', 'BackofficeController@masterprodusen');
  Route::get('/backoffice/produsen-supplier/createprodusen', 'BackofficeController@createmasterprodusen');
  Route::post('/backoffice/produsen-supplier/storeprodusen', 'BackofficeController@storemasterprodusen')->name('backoffice/masterprodusen.store');
  Route::get('/backoffice/produsen-supplier/kode/{id}/edit', 'BackofficeController@editmasterprodusen');
  Route::post('/backoffice/produsen-supplier/kode/{id}/update', 'BackofficeController@updatemasterprodusen')->name('backoffice/masterprodusen.update');
  Route::get('/backoffice/produsen-supplier/kode/{id}/delete', 'BackofficeController@deletemasterprodusen');
  ///master jenis racikan ======================================================================================
  Route::get('/master/jenis_racikan', 'MasteritemController@jenisracikan');
  Route::get('/master/jenis_racikan/createjenisracikan', 'MasteritemController@createjenisracikan');
  Route::post('/master/jenis_racikan/storejenisracikan', 'MasteritemController@storejenisracikan')->name('jenisracikan.store');
  Route::get('/master/jenis_racikan/kode/{id}/edit', 'MasteritemController@editjenisracikan');
  Route::post('/master/jenis_racikan/kode/{id}/update', 'MasteritemController@updatejenisracikan')->name('jenisracikan.update');
  Route::get('/master/jenis_racikan/kode/{id}/delete', 'MasteritemController@deletejenisracikan');
  ///master Satuan ======================================================================================
  Route::get('/master/satuan', 'MasteritemController@satuan');
  Route::get('/master/satuan/createsatuan', 'MasteritemController@createsatuan');
  Route::post('/master/satuan/storesatuan', 'MasteritemController@storesatuan')->name('satuan.store');
  Route::get('/master/satuan/kode/{id}/edit', 'MasteritemController@editsatuan');
  Route::post('/master/satuan/kode/{id}/update', 'MasteritemController@updatesatuan')->name('satuan.update');
  Route::get('/master/satuan/kode/{id}/delete', 'MasteritemController@deletesatuan');
  ///master Kategori Obat ======================================================================================
  Route::get('/master/kategori_obat', 'MasteritemController@kategoriobat');
  Route::get('/master/kategori_obat/createkategori_obat', 'MasteritemController@createkategoriobat');
  Route::post('/master/kategori_obat/storekategori_obat', 'MasteritemController@storekategoriobat')->name('kategoriobat.store');
  Route::get('/master/kategori_obat/kode/{id}/edit', 'MasteritemController@editkategoriobat');
  Route::post('/master/kategori_obat/kode/{id}/update', 'MasteritemController@updatekategoriobat')->name('kategoriobat.update');
  Route::get('/master/kategori_obat/kode/{id}/delete', 'MasteritemController@deletekategoriobat');
  ///master Golongan Obat ======================================================================================
  Route::get('/master/golongan_obat', 'MasteritemController@golonganobat');
  Route::get('/master/golongan_obat/creategolongan_obat', 'MasteritemController@creategolonganobat');
  Route::post('/master/golongan_obat/storegolongan_obat', 'MasteritemController@storegolonganobat')->name('golonganobat.store');
  Route::get('/master/golongan_obat/kode/{id}/edit', 'MasteritemController@editgolonganobat');
  Route::post('/master/golongan_obat/kode/{id}/update', 'MasteritemController@updategolonganobat')->name('golonganobat.update');
  Route::get('/master/golongan_obat/kode/{id}/delete', 'MasteritemController@deletegolonganobat');
  ///master Obat Program======================================================================================
  Route::get('/master/obat_program', 'MasteritemController@obatprogram');
  Route::get('/master/obat_program/createobat_program', 'MasteritemController@createobatprogram');
  Route::post('/master/obat_program/storeobat_program', 'MasteritemController@storeobatprogram')->name('obatprogram.store');
  Route::get('/master/obat_program/kode/{id}/edit', 'MasteritemController@editobatprogram');
  Route::post('/master/obat_program/kode/{id}/update', 'MasteritemController@updateobatprogram')->name('obatprogram.update');
  Route::get('/master/obat_program/kode/{id}/delete', 'MasteritemController@deleteobatprogram');
  ///master Obat All======================================================================================
  Route::get('/master-obat-all', 'MasteritemController@obatall');
  Route::get('/master-obat-all/update', 'MasteritemController@update');
  Route::get('/master-obat-all/createobat-all', 'MasteritemController@createobatall');
  Route::post('/master/obat_program/storeobat-all', 'MasteritemController@storeobatall')->name('obatall.store');
  Route::get('/master-obat-all/kode/{id}/edit', 'MasteritemController@editobatall');
  Route::post('/master-obat-all/kode/{id}/update', 'MasteritemController@updateobatall')->name('obatall.update');
  Route::get('/master-obat-all/kode/{id}/delete', 'MasteritemController@deleteobatall');
  ///master NonMedis======================================================================================
  Route::get('/master-nonmedis', 'MasteritemController@nonmedis');
  Route::get('/master-nonmedis/createnonmedis', 'MasteritemController@createnonmedis');
  Route::post('/master-nonmedis/storenonmedis', 'MasteritemController@storenonmedis')->name('nonmedis.store');
  Route::get('/master-nonmedis/kode/{id}/edit', 'MasteritemController@editnonmedis');
  Route::post('/master-nonmedis/kode/{id}/update', 'MasteritemController@updatenonmedis')->name('nonmedis.update');
  Route::get('/master-nonmedis/kode/{id}/delete', 'MasteritemController@deletenonmedis');
  //
});
