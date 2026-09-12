<?php
Route::group(['middleware' => ['web', 'auth','role:administrator|rawatinap|gizi']], function () {
		Route::resource('mastergizi', 'MastergiziController');
		Route::get('gizi-pasien', 'MastergiziController@gizi_pasien');
		Route::post('tambah_gizi_pasien', 'MastergiziController@storegizi');
		Route::get('/gizi/edit/{id}', 'MastergiziController@editgizi');
		Route::post('/gizi/update', 'MastergiziController@updategizi');
 
		Route::get('histori-gizi-pasien', 'MastergiziController@histori_gizi_pasien');
		Route::post('gizi-pasien', 'MastergiziController@gizi_pasien_byTanggal');
		Route::post('histori-gizi-pasien', 'MastergiziController@histori_gizi_pasien_byTanggal');

		//master diet pasien ======================================================================
		Route::get('master-diet-pasien', 'MastergiziController@indexdietpasien');
		Route::get('getdata-diet', 'MastergiziController@getDatadietpasien');
		Route::post('masterdietpasien', 'MastergiziController@storediet');
		Route::get('/masterdietpasien/edit/{id}', 'MastergiziController@editdiet');
		Route::post('/masterdietpasien/update', 'MastergiziController@updatediet');
 
		
		

	});
