<?php
// Alergi
Route::get('/alergi/get-data-histori-alergi/{id}','AlergiController@get_data_histori_alergi');
Route::post('/alergi/post-data-histori-alergi','AlergiController@input_histori_alergi');
Route::get('/alergi/hapus-data-histori-alergi/{id}','AlergiController@hapus_histori_alergi');
