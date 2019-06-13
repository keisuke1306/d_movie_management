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

Route::get('/', 'HomeController@index');

Route::get(config('movie_manage.uri_word') . '/home', 'HomeController@index');
Route::get(config('movie_manage.uri_word') . '/ranking', 'RankingController@index');
Route::get(config('movie_manage.uri_word') . '/actor', 'ActorController@index');
Route::get(config('movie_manage.uri_word') . '/actor/search_movie', 'ActorController@search_movie');
Route::get(config('movie_manage.uri_word') . '/movie/watch/{id}', 'MovieController@watch');
