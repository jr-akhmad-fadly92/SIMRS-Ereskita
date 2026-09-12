<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'pasien', 'namespace' => 'Modules\Pasien\Http\Controllers'], function()
{
    Route::get('/', 'PasienController@index')->name('pasien');
    Route::get('/create', 'PasienController@create')->name('pasien.create');
    Route::post('/store', 'PasienController@store')->name('pasien.store');
    Route::get('/{id}/edit', 'PasienController@edit')->name('pasien.edit');
    Route::put('/{id}', 'PasienController@update')->name('pasien.update');
    Route::get('/getkota/{province_id}', 'PasienController@getKabupaten');
    Route::get('/getdistrict/{regency_id}', 'PasienController@getKecamatan');
    Route::get('/getdesa/{district_id}', 'PasienController@getDesa');
    Route::get('/{id}/show', 'PasienController@show');
    Route::post('/search', 'PasienController@search')->name('pasien.search');

    Route::get('getdata-datatable', 'PasienController@getData');
    Route::get('search-pasien/{antrian_id}/{no_loket}', 'PasienController@searchPasien');
    Route::get('search-pasien-igd/{url?}', 'PasienController@searchPasienIGD');

    // rekam medis pasien
    Route::get('/rekammedispasien', 'PasienController@indexrekammedispasien')->name('rekammedispasien');
    
    Route::get('/{id}/showrekammedispasien', 'PasienController@showrekammedispasien');
    Route::post('/searchrekammedispasien', 'PasienController@searchrekammedispasien')->name('pasien.search');

    Route::get('getdata-datatable1', 'PasienController@getDataRekamMedis');
});
