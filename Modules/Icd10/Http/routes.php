<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'icd10', 'namespace' => 'Modules\Icd10\Http\Controllers'], function()
{
    Route::get('/', 'Icd10Controller@index')->name('icd10');
    Route::get('/create', 'Icd10Controller@create')->name('icd10.create');
    Route::post('/store', 'Icd10Controller@store')->name('icd10.store');
    Route::get('/{id}/edit', 'Icd10Controller@edit')->name('icd10.edit');
    Route::put('/{id}', 'Icd10Controller@update')->name('icd10.update');

    Route::get('/getICD10', 'Icd10Controller@getICD10');
    Route::get('/getData/{no?}', 'Icd10Controller@getDataIcd10');
    Route::get('/getICD10/list', 'Icd10Controller@getDataIcd10_list');

    //list riwayat icd10
    Route::get('/list_riwayat_icd_10/{id}', 'Icd10Controller@get_data_riwayat_icd10');
    Route::post('/post_riwayat_icd_10', 'Icd10Controller@update_data_riwayat_icd10');
    Route::get('/hapus_riwayat_icd_10/{id}', 'Icd10Controller@hapus_histori_riwayat_icd10');

    //list riwayat turunan
    Route::get('/list_riwayat_penyakit_turunan/{id}', 'Icd10Controller@get_data_riwayat_turunan');
    Route::post('/post_riwayat_penyakit_turunan', 'Icd10Controller@update_data_riwayat_turunan');
    Route::get('/hapus_riwayat_penyakit_turunan/{id}', 'Icd10Controller@hapus_histori_riwayat_turunan');
    //list assesment
    Route::get('/list_assesment/{id}', 'Icd10Controller@get_data_assesment');
    Route::post('/post_assesment', 'Icd10Controller@update_data_assesment');
    Route::get('/hapus_assesment/{id}', 'Icd10Controller@hapus_assesment');
});
