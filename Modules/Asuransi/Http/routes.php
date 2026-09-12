<?php

Route::group(['middleware' => 'web', 'prefix' => 'asuransi', 'namespace' => 'Modules\Asuransi\Http\Controllers'], function()
{
  Route::get('/', 'AsuransiController@index')->name('asuransi');
  Route::get('/create', 'AsuransiController@create')->name('asuransi.create');
  Route::post('/store', 'AsuransiController@store')->name('asuransi.store');
  Route::put('/{id}', 'AsuransiController@update')->name('asuransi.update');
  Route::get('/{id}/edit', 'AsuransiController@edit')->name('asuransi.edit');
});
