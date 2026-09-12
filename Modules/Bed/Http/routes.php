<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'bed', 'namespace' => 'Modules\Bed\Http\Controllers'], function()
{
    Route::get('/', 'BedController@indexbaru')->name('bed');
    Route::post('/', 'BedController@indexbaru_request');
    Route::get('/create', 'BedController@create')->name('bed.create');
    Route::post('/store', 'BedController@store')->name('bed.store');
    Route::get('/{id}/edit', 'BedController@edit')->name('bed.edit');
    Route::put('/{id}', 'BedController@update')->name('bed.update');
		Route::get('/display-bed', 'BedController@display_bed');
    Route::get('/kosongkan/{id}', 'BedController@kosongkanBed')->name('bed.kosongkan');
    Route::get('/kosongkanbatal/{id}', 'BedController@batalKosongkanBed')->name('bed.kosongkanbatal');
});
