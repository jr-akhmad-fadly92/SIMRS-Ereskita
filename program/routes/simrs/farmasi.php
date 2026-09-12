<?php
Route::group(['middleware'=>['web','auth', 'role:administrator|apotik']], function () {
  Route::view('farmasi/master', 'farmasi.master');
  Route::view('farmasi/laporan', 'farmasi.laporan');
 });
Route::group(['middleware'=>['web','auth']], function () {

  Route::view('farmasi/penjualan', 'farmasi.penjualan');
  Route::view('farmasi/reture-penjualan', 'farmasi.reture-penjualan');
  
  //Master Etiket
  Route::get('farmasi/etiket', 'EtiketController@index');
  Route::get('farmasi/etiket/create', 'EtiketController@create');
  Route::post('farmasi/etiket/store', 'EtiketController@store');
  Route::get('farmasi/etiket/{id}/edit', 'EtiketController@edit');
  Route::put('farmasi/etiket/update/{id}', 'EtiketController@update');

  //laporan
  Route::post('farmasi/laporan/periodetanggal', 'FarmasiController@periodeTanggal');
  Route::get('farmasi/laporan/penjualan/', 'FarmasiController@lap_farmasi');
  Route::post('farmasi/laporan/penjualan/', 'FarmasiController@lap_farmasi_byTanggal');
  Route::get('farmasi/laporan/etiket/{jenis?}/{penjualan_id}', 'FarmasiController@cetak_etiket');
  Route::get('farmasi/laporan/hapus/{no_resep}', 'FarmasiController@hapusLaporan');
  Route::get('farmasi/cetak-detail/{penjualan_id}', 'FarmasiController@cetakDetail');
  Route::get('farmasi/cetak-resep/{penjualan_id}', 'FarmasiController@cetakResep');
  Route::get('farmasi/laporan/etiketbebas/{penjualan_id}', 'FarmasiController@cetak_etiket_bebas');
	
  Route::get('farmasi/get-masterobat/{id}', 'FarmasiController@getMasterobat');
  Route::get('farmasi/get-racikan/{id}', 'FarmasiController@getRacikan');
	
	// TELAAH
	Route::get('farmasi/telaah-resep/{jenis}/{registrasi_id}', 'FarmasiController@telaahResep');
	Route::post('farmasi/simpan-telaah', 'FarmasiController@simpanTelaah');

  //PO
  Route::get('po', 'PoController@index');
  Route::get('po-data', 'PoController@dataPO');
  Route::get('po-data-detail/{id}', 'PoController@dataDetailPO');
  Route::get('po-hapus-detail/{id}', 'PoController@delete');
  Route::get('po-cetak/{id}', 'PoController@cetak');
  Route::get('po-order', 'PoController@order');
  Route::post('po-order', 'PoController@addItem');
  Route::get('po-order/{id}', 'PoController@updateOrder');
  Route::get('po-kirim-order/{id}', 'PoController@kirimOrder');
  Route::get('po-masterobat', 'PoController@masterObat');
  Route::get('po-masterobat-pilihan', 'PoController@masterObatPilihan');
  Route::post('po-simpanitem', 'PoController@SimpanItem');
  Route::get('po-detail/{po_id}', 'PoController@detailPO');
  
  //RETUR OBAT
  Route::get('retur', 'ReturController@index');
  Route::get('retur-order', 'ReturController@order');
  Route::post('retur-order', 'ReturController@addItem');
  Route::get('retur-order/{id}', 'ReturController@updateOrder');
  Route::get('retur-masterobat', 'ReturController@masterObat');
  Route::post('retur-simpanitem', 'ReturController@SimpanItem');
  Route::get('retur-detail/{po_id}', 'ReturController@detailRetur');
  Route::get('retur-kirim-order/{id}', 'ReturController@kirimRetur');
  Route::get('retur-hapus-detail/{id}', 'ReturController@delete');
  Route::get('retur-data', 'ReturController@dataRetur');
  Route::get('retur-data-detail/{id}', 'ReturController@dataDetailRetur');

  // DEPO
  Route::get('depo-obat', 'PoController@depoIndex');
  Route::get('depo-data', 'PoController@dataDepo');
  Route::get('depo-obat/order', 'PoController@depoOrder');
  Route::post('depo-obat/order', 'PoController@addItemDepo');
  Route::get('depo-masterobat/{val}', 'PoController@depoMasterObat');
  Route::get('depo-detail/{po_id}', 'PoController@depoDetail');
  Route::get('depo-data-detail/{id}', 'PoController@dataDepoDetail');
  Route::get('depo-order/{id}', 'PoController@updateDepoOrder');
	Route::post('depo-simpanitem/{val}', 'PoController@depoSimpanItem');
  Route::get('depo-hapus-detail/{id}', 'PoController@DepoDelete');
  Route::get('depo-kirim-order/{id}', 'PoController@depoKirimOrder');
  
  // DISTRIBUSI
  Route::get('dist', 'PoController@distIndex');
  Route::get('dist-update-pemberian/{value}/{no_po}/{kode_item}', 'PoController@updatePemberian');
  Route::get('dist-simpan-setuju/{no_po}', 'PoController@setujuPemberian');

  //FAKTUR
  Route::get('faktur', 'FakturController@index');
  Route::post('faktur-save', 'FakturController@saveFaktur');
  
  //PEMAKAIAN
  Route::get('pemakaian-detail/{no_resep}', 'FarmasiController@detailPemakaian');
  Route::post('pemakaian-simpan', 'FarmasiController@simpanPemakaian');
  Route::get('pemakaian-hapus/{id}', 'FarmasiController@hapusPemakaian');
  
  Route::get('resep-ubah-etiket/{jenis}/{id}/{etiket}', 'FarmasiController@ubahEtiket');
  //EPO
  Route::get('epo-detail/{no_resep}', 'FarmasiController@detailPermintaan');
  Route::post('epo-simpan', 'FarmasiController@simpanPermintaan');
  Route::get('epo-hapus/{id}', 'FarmasiController@hapusPermintaan');
  Route::get('epo-copy/{id}', 'FarmasiController@copyPermintaan');
  Route::get('farmasi/cetak-epo/{id}', 'FarmasiController@cetakEpo');
	
  //RESEP
  Route::get('resep-detail/{no_resep}', 'FarmasiController@detailResep');
  Route::post('resep-simpan', 'FarmasiController@simpanResep');
  Route::get('resep-hapus/{id}/{jumlah}/{alasan}', 'FarmasiController@hapusResep');
  Route::get('resep-retur/{pasien_id}/{registrasi_id}', 'FarmasiController@returResep');
  Route::get('resep-retur/{id}/{jumlah}/{alasan}', 'FarmasiController@hapusResep');
  Route::get('farmasi/cetak/pengembalian-uang/{id}', 'FarmasiController@cetakUangKembali');

  Route::post('epo-add-racikan', 'FarmasiController@addRacikanEpo');
  Route::post('resep-add-racikan', 'FarmasiController@addRacikanResep');
});
