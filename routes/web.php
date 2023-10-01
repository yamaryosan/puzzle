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
