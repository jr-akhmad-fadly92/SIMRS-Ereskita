<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'kategoritarif', 'namespace' => 'Modules\Kategoritarif\Http\Controllers'], function()
{
    Route::get('/', 'KategoritarifController@index')->name('kategoritarif');
    Route::get('/create', 'KategoritarifController@create')->name('kategoritarif.create');
    Route::post('/store', 'KategoritarifController@store')->name('kategoritarif.store');
    Route::get('/{id}/edit', 'KategoritarifController@edit')->name('kategoritarif.edit');
    Route::put('/{id}', 'KategoritarifController@update')->name('kategoritarif.update');

    //pelaksana tarif
    Route::get('/pelaksana', 'KategoritarifController@indexpelaksana')->name('kategoritarif.pelaksana');
    Route::get('/createpelaksana', 'KategoritarifController@createpelaksana')->name('kategoritarif.createpelaksana');
    Route::post('/storepelaksana', 'KategoritarifController@storepelaksana')->name('kategoritarif.storepelaksana');
    Route::get('/{id}/editpelaksana', 'KategoritarifController@editpelaksana')->name('kategoritarif.editpelaksana');
    Route::put('/editpelaksana/{id}', 'KategoritarifController@updatepelaksana')->name('kategoritarif.updatepelaksana');

});
