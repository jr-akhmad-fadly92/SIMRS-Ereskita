<?php
Route::group(['middleware'=>['web','auth','role:administrator|logistik']], function () {
 
  //stok gudang obat
  Route::get('/gudang-obat','LogistikController@gudangobat');
  //PO Obat
  Route::get('/gudang/po-obat','LogistikController@po_obat');
  //Route::post('/gudang/getSupplier', 'LogistikController@getSupplier');
  Route::get('/gudang/po-obat/pdf/{id}','LogistikController@pdfpo_obat');
  Route::get('/gudang/po-obat/order/{id}', 'LogistikController@depoOrder');
 
  Route::post('/gudang/po-obat/order', 'LogistikController@addItemDepo');
  Route::get('/gudang/po-obat/detail-order/{id}', 'LogistikController@tampilDepo');
  Route::get('/gudang/po-obat/delete/{id}', 'LogistikController@DepoDelete');
  Route::get('master-obat/{id}', 'LogistikController@Masterobat');
  Route::post('/gudang/po-obat/simpanitem', 'LogistikController@SimpanItemobat');
  Route::get('/gudang/po-obat/{po_id}', 'LogistikController@depoDetailobat');
  Route::get('/gudang/po-obat/kirim-order-inv/{id}', 'LogistikController@depoKirimOrder');
  Route::get('/gudang/po-obat/order-obat/{id}', 'LogistikController@updateDepoOrder');
  // Penerimaan Obat
  Route::get('/gudang/penerimaan-obat/laporan','LogistikController@pdf_laporan');
  Route::get('/gudang/penerimaan-obat','LogistikController@penerimaan_obat');
  Route::get('/gudang/penerimaan/simpan/{id}','LogistikController@selesai_penerimaan');
  Route::get('/gudang/penerimaan-obat/list-po','LogistikController@list_po');
  Route::get('/gudang/penerimaan-obat/list-faktur','LogistikController@list_faktur');
  Route::get('/gudang/penerimaan-obat/pdf/{id}','LogistikController@pdfpenerimaan_obat');
  Route::get('/gudang/penerimaan-obat/order/{id}', 'LogistikController@depopenerimaan');
  Route::post('/gudang/penerimaan-obat/orderdetail/{id}', 'LogistikController@addItemDepopenerimaan');
  Route::post('/gudang/penerimaan-obat/simpanitem', 'LogistikController@simpanItemDepopenerimaan');
  Route::get('/gudang/penerimaan-obat/list-faktur/{id}', 'LogistikController@get_detail_faktur');
  Route::get('/gudang/penerimaan-obat/laporan_penerimaan/{id}','LogistikController@pdfpo_laporan_penerimaan');
  Route::get('/gudang/penerimaan-obat/retur_penerimaan/{id}','LogistikController@pdfpo_retur_penerimaan');
  //Route::get('/gudang/penerimaan-obat/{po_id}', 'LogistikController@depopenerimaanDetailobat');
  //Route::get('/gudang/penerimaan-obat/kirim-order-inv/{id}', 'LogistikController@depopenerimaanKirimOrder');
  //Route::get('/gudang/penerimaan-obat/order-obat/{id}', 'LogistikController@updateDepopenerimaanOrder');

  // PO Order Obat Gudang 
  Route::get('/gudang/dist-obat','LogistikController@dist_obat');
  Route::get('/gudang/update_obat','LogistikController@update');
  Route::get('/gudang/dist-obat/list_po','LogistikController@list_dist_obat');
  Route::get('/gudang/dist-obat/detail/{id}','LogistikController@detail_dist_obat');
  Route::get('/gudang/dist-obat/detail/list/{id}','LogistikController@po_Dist_Detail');
  Route::post('/gudang/dist-obat/simpanitem', 'LogistikController@simpanItempoobat');
  Route::get('/gudang/dist-obat/deleteitem/{id}', 'LogistikController@deleteItempoobat');
  Route::get('/gudang/dist-obat/resetitem/{id}', 'LogistikController@resetItempoobat');
  Route::post('/gudang/dist-obat/tambahitem/{id}', 'LogistikController@tambahItempoobat');
  Route::get('/gudang/dist-obat/selesai/{id}', 'LogistikController@selesaiItempoobat');
  Route::get('/gudang/dist-obat/po-data', 'LogistikController@dataPO');
  Route::get('/gudang/dist-obat/po-data-detail/{id}', 'LogistikController@dataDetailPO');

  
  // PO Order nonmedis dari Gudang 
  Route::get('/gudang/dist-nonmedis','LogistikController@dist_nonmedis');
  Route::get('/gudang/update_obat','LogistikController@update');
  
  Route::get('/gudang/dist-nonmedis/detail/{id}','LogistikController@detail_dist_nonmedis');
 
  Route::post('/gudang/dist-nonmedis/simpanitem', 'LogistikController@simpanItempononmedis');
  Route::get('/gudang/dist-nonmedis/deleteitem/{id}', 'LogistikController@deleteItempononmedis');
  Route::get('/gudang/dist-nonmedis/resetitem/{id}', 'LogistikController@resetItempononmedis');
  Route::post('/gudang/dist-nonmedis/tambahitem/{id}', 'LogistikController@tambahItempononmedis');
  Route::get('/gudang/dist-nonmedis/selesai/{id}', 'LogistikController@selesaiItempononmedis');
  Route::get('/gudang/dist-nonmedis/po-data', 'LogistikController@dataPOnonmedis');
  Route::get('/gudang/dist-nonmedis/list-po-data/{id}', 'LogistikController@dataPOdetailnonmedis');
  Route::get('/gudang/dist-nonmedis/po-data-detail/{id}', 'LogistikController@dataDetailPOnonmedis');

  // stok opnam
  Route::get('/stok-opnam/listall','LogistikController@get_data_stokopnam');
  Route::get('/stok-opnam/printlaporan/{id}','LogistikController@pdflap_stok_opnam');
  Route::get('/stok-opnam/list','LogistikController@stokopnam');
  Route::get('/stok-opnam/open_create','LogistikController@opencreatestokopnam');
  Route::post('/stok-opnam/create','LogistikController@createstokopnam');
  Route::get('/stok-opnam/detail/{id}','LogistikController@detailstokopnam');
  Route::get('/stok-opnam/list_detail_stok/{id}','LogistikController@liststokopnam');
  Route::post('/stok-opnam/update_detail_stok','LogistikController@updatedetailstokopnam');
  Route::get('stok-opnam-update-pemberian/{value}/{no_po}/{kode_item}','LogistikController@update_stok_opnam');
  Route::get('stok-opnam-update-keterangan/{value}/{no_po}/{kode_item}','LogistikController@update_ketstok_opnam');
  Route::get('/stok-opnam/selesai/{id}','LogistikController@selesaistokopnam');
  // gudang obat
  Route::get('/get-data-gudang-obat','LogistikController@get_data_gudang_obat');

  //Retur Obat
  Route::get('/gudang/retur','ReturController@retur_supplier');
  Route::get('/gudang/retur-data', 'ReturController@dataRetur_supplier');
  Route::get('/gudang/retur-pdf/{id}', 'ReturController@pdf_retur');
  Route::get('/gudang/retur/order', 'ReturController@order_supplier');
  Route::post('/gudang/retur/order', 'ReturController@addItem_supplier');
  Route::get('/gudang/retur/order/{id}', 'ReturController@updateOrder_supplier');
  Route::get('/gudang/retur-masterobat', 'ReturController@masterObat_supplier');
  Route::post('/gudang/retur/simpanitem', 'ReturController@SimpanItem_supplier');
  Route::get('/gudang/retur-detail/{po_id}', 'ReturController@detailRetur_supplier');
  Route::get('/gudang/retur-hapus-detail/{id}', 'ReturController@delete_supplier');
  Route::get('/gudang/retur-kirim-order/{id}', 'ReturController@kirimRetur_supplier');
  
});

Route::group(['middleware'=>['web','auth']], function () {
 //order Non Medis ke gudang
 Route::get('depo-nonmedis', 'LogistikController@depononIndex');
 Route::get('depo-data-nonmedis', 'LogistikController@dataDepononmedis');
 Route::get('depo-nonmedis/order', 'LogistikController@depoOrdernonmedis');
 Route::post('depo-nonmedis/order', 'LogistikController@addItemDepononmedis');
 Route::get('depo-master-nonmedis', 'LogistikController@depoMasterNonmedis');
 Route::get('depo-detail-nonmedis/{po_id}', 'LogistikController@depoDetailnonmedis');
 Route::get('depo-data-detail-nonmedis/{id}', 'LogistikController@dataDepoDetailnonmedis');
 Route::get('depo-order-nonmedis/{id}', 'LogistikController@updateDepoOrdernonmedis');
 Route::post('depo-simpanitem-nonmedis', 'LogistikController@depoSimpanItemnonmedis');
 Route::get('depo-hapus-detail-nonmedis/{id}', 'LogistikController@DepoDeletenonmedis');
 Route::get('depo-kirim-order-nonmedis/{id}', 'LogistikController@depoKirimOrdernonmedis');

  
  });
  
