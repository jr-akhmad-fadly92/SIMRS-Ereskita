<?php

Route::group(['middleware'=>['web','auth']], function () {
  Route::get('registrasi/v-claim/form-sep/', 'SepController@index');
  Route::post('registrasi/v-claim/simpan-sep', 'SepController@simpan_sep');
  Route::post('registrasi/v-claim/cari-peserta', 'SepController@cariPeserta');
  Route::post('cari-sep/noka', 'SepController@cari_nojkn');
  Route::get('cari-nik/{nik?}', 'SepController@cari_nik');
  Route::post('buat-sep', 'SepController@buat_sep');
  Route::post('simpan-no-sep', 'SepController@simpan_sep');
  Route::get('sep-sukses', 'SepController@sep_sukses');
  Route::get('cetak-sep/{no_sep}', 'SepController@cetak_sep');

  Route::get('sep/geticd10', 'SepController@getIcd10');
  Route::get('sep/get-kota/{kode}', 'SepController@getKota');
  Route::get('sep/get-kecamatan/{kode}', 'SepController@getKecamatan');
  Route::get('sep/get-faskes', 'SepController@getFaskes');
  Route::post('sep/buat-rujukan', 'SepController@buatRujukan');
  Route::get('sep/cetak-rujukan/{no_rujukan}', 'SepController@cetakRujukan');
  Route::get('sep/data-lpk/{regid}', 'SepController@dataLpk');

  //IRNA
  Route::get('cari-sep-irna/noka/{no_kartu}/{registrasi_id}', 'SepController@cari_nojknIRNA');
  Route::get('sep-update-tgl-pulang/{noSep}/{tglPulang}', 'SepController@updateTglPulang');

});
