<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'tarif', 'namespace' => 'Modules\Tarif\Http\Controllers'], function()
{
    //Tarif Irna
    Route::get('/', 'TarifController@index')->name('tarif');
    Route::post('/filter-by-request', 'TarifController@filterByRequest');

    Route::post('/jasa_medis_update', 'TarifController@update_jasa_medis');
    
    Route::get('/create', 'TarifController@create')->name('tarif.create');
    Route::post('/store', 'TarifController@store')->name('tarif.store');
    Route::get('/{id}/edit', 'TarifController@edit')->name('tarif.edit');
    Route::get('/{id}/hapus', 'TarifController@delete')->name('tarif.hapus');
    Route::put('/update/{id}', 'TarifController@update')->name('tarif.update');
    Route::get('/cek-split/{id}', 'TarifController@cek_split');

    //Tarif IRJ
    Route::post('/by-kategori-header', 'TarifController@byKategoriHeader')->name('tarif.by-kategori-header');
    Route::get('rawatjalan/{thntarif_id?}/{kategoriheader_id?}', 'TarifController@tarif_rawatjalan');
    //Tarif IGD
    Route::post('/rawatdarurat-by-kategori-header', 'TarifController@igdByKategoriHeader')->name('tarif.rawatdarurat-by-kategori-header');
    Route::get('rawatdarurat/{thntarif_id?}/{kategoriheader_id?}', 'TarifController@tarif_darurat')->name('tarif.rawatdarurat');
});
