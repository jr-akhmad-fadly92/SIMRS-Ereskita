<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'config', 'namespace' => 'Modules\Config\Http\Controllers'], function()
{
    Route::get('/app', 'ConfigController@index')->name('config');
    Route::get('/create', 'ConfigController@create')->name('config.create');
    Route::post('/store', 'ConfigController@store')->name('config.store');
    Route::get('/{id}/edit', 'ConfigController@edit')->name('config.edit');
    Route::put('/{id}', 'ConfigController@update')->name('config.update');
});
