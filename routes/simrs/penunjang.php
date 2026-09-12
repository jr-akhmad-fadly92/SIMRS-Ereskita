<?php
// Master
Route::group(['middleware'=>['web','auth','role:rawatinap|rawatdarurat|rawatjalan|fisioterapi|kamarbersalin|administrator']], function () {
  Route::post('penunjang/save-tindakan','PenunjangController@saveTindakan');
  Route::get('penunjang/hapus-tindakan/{penunjang}/{id}/{idreg}/{pasien_id}', 'PenunjangController@hapusTindakan');
  Route::get('penunjang/tindakan-pasien', 'PenunjangController@tindakan_pasien');
 // Route::get('penunjang/tindakan-pasien', 'PenunjangController@tindakan_pasien');
	Route::get('penunjang/insert-kunjungan/{registrasi_id}/{pasien_id}','PenunjangController@insertKunjungan');
  Route::get('penunjang/entry-tindakan/{idreg}/{idpasien}','PenunjangController@entryTindakan');
  Route::post('penunjang/update-pelaksana', 'PenunjangController@updatePelaksana');
  Route::get('penunjang/selesai/{reg_id}', 'PenunjangController@selesai');
});
