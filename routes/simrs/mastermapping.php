<?php
Route::group(['middleware'=>['web','auth']], function () {
  Route::get('mastermapping', 'MastermappingController@index')->name('mastermapping');
  Route::post('mastermapping', 'MastermappingController@store')->name('mastermapping.store');
  Route::get('mastermapping/{id}/show', 'MastermappingController@show')->name('mastermapping.show');
  Route::get('data-mastermapping', 'MastermappingController@dataList')->name('data-mastermapping');
  Route::get('mastermapping/{id}/edit', 'MastermappingController@edit')->name('mastermapping.edit');
  Route::patch('mastermapping/{id}', 'MastermappingController@update')->name('mastermapping.update');

});
