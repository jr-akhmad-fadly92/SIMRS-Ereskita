<?php

Route::group(['middleware' => ['web','auth'], 'prefix' => 'registrasi', 'namespace' => 'Modules\Registrasi\Http\Controllers'], function(){
	Route::get('/', 'RegistrasiController@index')->name('registrasi');
	Route::get('/create/{id?}', 'RegistrasiController@create')->name('registrasi.create');
	Route::post('/store', 'RegistrasiController@store')->name('registrasi.store');
	Route::get('/show', 'RegistrasiController@show')->name('registrasi.show');
	Route::put('/{id}', 'RegistrasiController@update')->name('registrasi.update');
	Route::post('/search', 'RegistrasiController@search')->name('registrasi.search');
	Route::post('/search_ajax', 'RegistrasiController@search_ajax')->name('registrasi.search_ajax');
	Route::get('/create_umum/{id?}', 'RegistrasiController@create_umum')->name('registrasi.create_umum');

	//IGD JKN
	Route::get('/igd/jkn/{id?}', 'RegistrasiController@reg_igd_jkn');
	Route::get('/igd/jknlama', 'RegistrasiController@reg_igd_jkn_lama');
	Route::get('/igd/jkn-blm-terdata', 'RegistrasiController@reg_igd_jkn_blmterdata');

	//IGD UMUM
	Route::get('/igd/umum/{id?}', 'RegistrasiController@reg_igd_umum');
	Route::get('/igd/umumlama', 'RegistrasiController@reg_igd_umum_lama');
	Route::get('/igd/umum-blm-terdata', 'RegistrasiController@reg_igd_umum_blmterdata');

	Route::get('/dataicd10', 'RegistrasiController@get_icd10');
	
	//BAYI
	Route::get('/create/{id?}/{bayi}', 'RegistrasiController@create')->name('registrasi.create');
	Route::get('/create_umum/{id?}/{bayi}', 'RegistrasiController@create_umum')->name('registrasi.create_umum');

  Route::post('/update-pasien', 'RegistrasiController@updatePasien');
});
