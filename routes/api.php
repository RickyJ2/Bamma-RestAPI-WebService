<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('user/reqResetPassword', 'ResetPasswordController@requestLink');

Route::post('user/updateProfile/{id}', 'UserDataController@updateProfileImage');
Route::post('user/register', 'UserDataController@register');
Route::post('user/login', 'UserDataController@login');
Route::get('user/{id}', 'UserDataController@show');
Route::put('user/{id}', 'UserDataController@update');

Route::get('daftarMobil/show', 'daftarMobilController@index');
Route::get('daftarMobil/{id}', 'daftarMobilController@show');
Route::post('daftarMobil/add', 'daftarMobilController@create');

Route::get('cabang/show', 'cabangController@index');
Route::get('cabang/{id}', 'cabangController@show');

Route::get('pemesanan/{id_user}', 'pemesananController@show');
Route::post('pemesanan/add', 'pemesananController@create');
Route::put('pemesanan/{id}', 'pemesananController@update');

Route::post('rating/get/{id_user}', 'ratingController@get');
Route::post('rating/addupdate', 'ratingController@create');
Route::delete('rating/{id}', 'ratingController@delete');

Route::get('kritikSaran/{id_user}', 'kritikSaranController@show');
Route::post('kritikSaran/add', 'kritikSaranController@create');
Route::put('kritikSaran/{id}', 'kritikSaranController@update');
Route::delete('kritikSaran/{id}', 'kritikSaranController@delete');