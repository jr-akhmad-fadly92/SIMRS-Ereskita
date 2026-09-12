<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('/', 'UserController@index')->name('user');
    Route::get('/create', 'UserController@create')->name('user.create');
    Route::post('/store', 'UserController@store')->name('user.store');
    Route::get('/{id}/edit', 'UserController@edit')->name('user.edit');
    Route::put('/{id}', 'UserController@update')->name('user.update');
    Route::get('/{id}/show', 'UserController@show')->name('user.show');
    Route::post('/updateuser', 'UserController@updateUser');
});
