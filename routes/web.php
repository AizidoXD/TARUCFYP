<?php

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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Test URL to test ML code
Route::get('/test_ml', 'phpML@index');

//Upload Excel Route
Route::get('/upload_excel', 'ExcelController@index'); //Return the uploadExcel view
Route::post('/import_excel', 'ExcelController@importExcel'); //Post method to upload the excel file

