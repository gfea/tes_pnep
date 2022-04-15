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

Auth::routes();

Route::name('pages/')->middleware('auth')->group(function ()
{
    Route::get('pages/home', 'HomeController@index')->name('pages/home');
    Route::get('pages/gaji', 'GajiController@index')->name('pages/gaji');
    Route::post('pages/gaji/show', 'GajiController@show_gaji')->name('pages/gaji/show');
    Route::get('pages/gaji/show_add', 'GajiController@show_add')->name('pages/gaji/show_add');
    Route::get('pages/gaji/show_edit/{id}', 'GajiController@show_edit')->name('pages/gaji/show_edit');
    Route::post('pages/gaji/add', 'GajiController@add')->name('pages/gaji/add');
    Route::post('pages/gaji/edit', 'GajiController@edit')->name('pages/gaji/edit');
    Route::post('pages/gaji/view', 'GajiController@view')->name('pages/gaji/view');
    Route::post('pages/gaji/delete', 'GajiController@delete')->name('pages/gaji/delete');
    //Fibonacci
    Route::get('pages/fibonacci', 'FibonacciController@index')->name('pages/fibonacci');
    Route::post('pages/fibonacci/send', 'FibonacciController@send')->name('pages/fibonacci/send');
});
