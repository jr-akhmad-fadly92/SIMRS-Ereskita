<?php
Route::group(['middleware'=>['web','auth','role:administrator|logistik']], function () {
 
  Route::get('/backoffice','BackofficeController@index');

  //Inventaris Global =====================================================================================
  Route::get('/backoffice/Inv-global', 'BackofficeController@inventarisglobal');
  Route::get('/backoffice/Inv-global/refresh', 'BackofficeController@refresh_inv');
  
  Route::get('/backoffice/Inv-global/createinvglobal', 'BackofficeController@createinventarisglobal');
  Route::post('/backoffice/Inv-global/storeinvglobal', 'BackofficeController@storeinventarisglobal')->name('backoffice/inventarisglobal.store');
  Route::get('/backoffice/Inv-global/kode/{id}/edit', 'BackofficeController@editinventarisglobal');
  Route::post('/backoffice/Inv-global/kode/{id}/update', 'BackofficeController@updateinventarisglobal')->name('backoffice/inventarisglobal.update');
  Route::get('/backoffice/Inv-global/kode/{id}/delete', 'BackofficeController@deleteinventarisglobal');
  //Detail Inventaris=======================================================================================
  Route::get('/backoffice/Inv-detail/{id}', 'BackofficeController@inventarisdetail');
  Route::get('/backoffice/Inv-detail/refresh/{id}', 'BackofficeController@refresh_inv_detail');
  Route::get('/backoffice/Inv-detail/createinv/{id}', 'BackofficeController@createinventarisdetail');
  Route::post('/backoffice/Inv-detail/storeinv', 'BackofficeController@storeinventarisdetail')->name('backoffice/inventarisdetail.store');
  Route::get('/backoffice/Inv-detail/kode/{id}/edit', 'BackofficeController@editinventarisdetail');
  Route::post('/backoffice/Inv-detail/kode/{id}/update', 'BackofficeController@updateinventarisdetail')->name('backoffice/inventarisdetail.update');
  Route::get('/backoffice/Inv-detail/kode/{id}/{global}/delete', 'BackofficeController@deleteinventarisdetail');
  Route::get('/backoffice/Inv-detail/history/{id}', 'BackofficeController@historyinventarisdetail');
  Route::get('/backoffice/getruangan/{ruangan}', 'BackofficeController@getRuangan');
  // Mutasi Inventaris
  Route::get('/backoffice/Inv-mutasi', 'BackofficeController@inventarismutasi');
  Route::get('/backoffice/Inv-mutasi/{id}', 'BackofficeController@createinventarismutasi');
  Route::post('/backoffice/Inv-mutasi/storeinv', 'BackofficeController@storeinventarismutasi')->name('backoffice/inventarismutasi.store');
  

  // DISTRIBUSI
  Route::get('dist-inv', 'BackofficeController@distIndex');
  Route::get('dist-inv-update-pemberian/{value}/{no_po}/{kode_barang}', 'BackofficeController@updatePemberian');
  Route::get('dist-inv-simpan-setuju/{no_po}', 'BackofficeController@setujuPemberian');
  // PENGAJUAN INVENTARIS
  Route::get('pengajuan-inv', 'BackofficeController@pengajuanIndex');
  Route::get('pengajuang-depo-inv', 'BackofficeController@pengajuaninvIndex');
  Route::get('pengajuang-depo-data-inv', 'BackofficeController@dataDepo');
  Route::get('pengajuang-depo-inv/order', 'BackofficeController@depoOrder');
  Route::post('pengajuang-depo-inv/order', 'BackofficeController@addItemDepo');
  Route::get('pengajuang-depo-master-inv', 'BackofficeController@depoMasterInv');
  Route::get('pengajuang-depo-detail-inv/{po_id}', 'BackofficeController@depoDetail');
  Route::get('pengajuang-depo-data-detail-inv/{id}', 'BackofficeController@dataDepoDetail');
  Route::get('pengajuang-depo-order-inv/{id}', 'BackofficeController@updateDepoOrder');
	Route::post('pengajuang-depo-simpanitem-inv', 'BackofficeController@depoSimpanItem');
  Route::get('pengajuang-depo-hapus-detail-inv/{id}', 'BackofficeController@DepoDelete');
  Route::get('pengajuang-depo-kirim-order-inv/{id}', 'BackofficeController@depoKirimOrder');
  //
});
Route::group(['middleware'=>['web','auth']], function () {
//order inv ke gudang
Route::get('depo-inv', 'BackofficeController@depoinvIndex');
Route::get('depo-data-inv', 'BackofficeController@dataDepo');
Route::get('depo-inv/order', 'BackofficeController@depoOrder');
Route::post('depo-inv/order', 'BackofficeController@addItemDepo');
Route::get('depo-master-inv', 'BackofficeController@depoMasterInv');
Route::get('depo-detail-inv/{po_id}', 'BackofficeController@depoDetail');
Route::get('depo-data-detail-inv/{id}', 'BackofficeController@dataDepoDetail');
Route::get('depo-order-inv/{id}', 'BackofficeController@updateDepoOrder');
Route::post('depo-simpanitem-inv', 'BackofficeController@depoSimpanItem');
Route::get('depo-hapus-detail-inv/{id}', 'BackofficeController@DepoDelete');
Route::get('depo-kirim-order-inv/{id}', 'BackofficeController@depoKirimOrder');

//List Inventaris
Route::get('list-inventaris/{id}', 'BackofficeController@list_inventaris_unit');
Route::get('get-list-inventaris/{id}', 'BackofficeController@get_list_inventaris_unit');
Route::post('pengajuan-inventaris-rusak', 'BackofficeController@pengajuan_inventaris_hilang');
});
