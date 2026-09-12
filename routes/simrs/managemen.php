<?php
Route::group(['middleware'=>['web','auth', 'role:administrator|kepegawaian']], function () {
 Route::view('/managemen/kepegawaian', 'managemen.kepegawaian');

 // histori pegawai
 Route::get('/managemen/histori-pegawai', 'ManagemenController@historipegawai');
 Route::get('managemen/histori/get-data-pegawai', 'ManagemenController@get_data_pegawai');
 Route::get('managemen/histori-pegawai/{id}', 'ManagemenController@detail_historipegawai');
 Route::post('managemen/input-pendidikan', 'ManagemenController@input_pendidikan_pegawai');
 Route::post('managemen/input-kesehatan', 'ManagemenController@input_kesehatan_pegawai');
});
 
 