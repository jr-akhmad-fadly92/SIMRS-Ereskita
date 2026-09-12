<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('mapping-biaya', 'MappingbiayaController@index')->name('mapping-biaya');
  Route::get('data-mapping-biaya', 'MappingbiayaController@dataMappingBiaya')->name('data-mapping-biaya');
	Route::get('mapping-biaya-tarif/{kategori?}', 'MappingbiayaController@mappingBiaya');
  Route::post('simpan-mapping-biaya', 'MappingbiayaController@simpanMapping');
  Route::post('hapus-mapping-biaya', 'MappingbiayaController@hapusMapping');
  Route::post('simpan-mapping-group', 'MappingbiayaController@simpanMappingGroup');
  Route::get('mapping-biaya/{id}', 'MappingbiayaController@viewMappingBiaya');
  Route::get('hapus-mapping-group/{id}', 'MappingbiayaController@hapusMappingGroup');
});
