<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('collect', 'App\Http\Controllers\DataCollector@collect');
Route::get('data', 'App\Http\Controllers\DataController@index');
Route::get('data/{id}', 'App\Http\Controllers\DataController@show');
Route::post('data', 'App\Http\Controllers\DataController@store');
Route::put('data/{id}', 'App\Http\Controllers\DataController@update');
Route::delete('data/{id}', 'App\Http\Controllers\DataController@delete');
