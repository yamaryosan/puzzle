<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\QuestionsController@index');

Route::resource('questions', 'App\Http\Controllers\QuestionsController')->except('edit', 'update');
Route::get('/questions/create', 'App\Http\Controllers\QuestionsController@create')->name('questions.create');
Route::post('/questions/store', 'App\Http\Controllers\QuestionsController@store')->name('questions.store');
Route::get('/questions/{id}', 'App\Http\Controllers\QuestionsController@show')->name('questions.show');
Route::get('/questions/{id}/edit', 'App\Http\Controllers\QuestionsController@edit')->name('questions.edit');
Route::post('/questions/{id}/update', 'App\Http\Controllers\QuestionsController@update')->name('questions.update');
Route::get('/questions/{id}/delete', 'App\Http\Controllers\QuestionsController@destroy')->name('questions.destroy');
Route::post('/questions/delete_all', 'App\Http\Controllers\QuestionsController@deleteAll')->name('questions.deleteAll');

Route::resource('patterns', 'App\Http\Controllers\PatternsController');
Route::get('/patterns', 'App\Http\Controllers\PatternsController@index')->name('patterns.index');
Route::get('/patterns/create', 'App\Http\Controllers\PatternsController@create')->name('patterns.create');
Route::post('/patterns/store', 'App\Http\Controllers\PatternsController@store')->name('patterns.store');
Route::get('/patterns/{id}/edit', 'App\Http\Controllers\PatternsController@edit')->name('patterns.edit');
Route::post('/patterns/{id}/update', 'App\Http\Controllers\PatternsController@update')->name('patterns.update');
Route::get('/patterns/{id}', 'App\Http\Controllers\PatternsController@show')->name('patterns.show');
Route::get('/patterns/{id}/delete', 'App\Http\Controllers\PatternsController@destroy')->name('patterns.destroy');

Route::get('/genres/{id}', 'App\Http\Controllers\GenresController@show')->name('genres.show');
Route::get('/genres/{id}/edit', 'App\Http\Controllers\GenresController@edit')->name('genres.edit');
Route::put('/genres/{id}/update', 'App\Http\Controllers\GenresController@update')->name('genres.update');
