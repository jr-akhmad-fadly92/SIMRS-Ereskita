<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('pengunjung_irj/{tga?}/{tgb?}', 'ApiController@pengunjung');
Route::get('pengunjung_ird/{tga?}/{tgb?}', 'ApiController@pengunjung_ird');
Route::get('info-kamar', 'ApiController@infoKamar');
Route::get('antrian-poli/{tanggal?}/{poli_id?}', 'ApiController@antrianPoli');
Route::get('fasilitas', 'ApiController@fasilitas');
Route::get('jadwal-dokter', 'ApiController@jadwalDokter');
