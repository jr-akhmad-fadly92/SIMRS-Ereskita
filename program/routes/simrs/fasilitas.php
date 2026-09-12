<?php

Route::get('/fasilitas', 'FasilitasController@index')->name('fasilitas');
Route::put('/fasilitas/update/{id}', 'FasilitasController@update')->name('fasilitas.update');
