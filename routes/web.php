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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
        Route::get('ajaxRequest', 'MoviesController@getMovieDetailsTMDB');
        Route::post('ajaxRequest', 'MoviesController@getMovieDetailsTMDB');
        Route::get('fetchMoviesTMDB', 'MoviesController@fetchMoviesTMDB')->name('home');
        Route::post('fetchMoviesTMDB', 'MoviesController@fetchMoviesTMDB')->name('home');
        Route::get('/',array('as'=>'/','uses'=>'MoviesController@index'));
});


