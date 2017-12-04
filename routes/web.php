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
   $workers = \App\Worker::all(['id', 'name']);
    return view('welcome', [
        'workers' => $workers
    ]);
})->middleware('auth');

Route::post('/addWorker', 'SlotAndSpot@addWorker')->middleware('auth');
Route::post('/addProject', 'SlotAndSpot@addProject')->middleware('auth');
Route::get('worker/{id}/delete', 'SlotAndSpot@deleteWorker')->middleware('auth');

Route::get('project/{id}/delete', 'SlotAndSpot@deleteProject')->middleware('auth');
Route::post('{id}/addWorker', 'SlotAndSpot@addWorkerToProject')->middleware('auth');
Route::get('{id}/deleteWorker/{workerId}', 'SlotAndSpot@deleteWorkerFromProject')->middleware('auth');

Route::get('/dailySpotAndSlot', 'SlotAndSpot@dailySpotAndSlot');


Route::get('/home', 'HomeController@index')->name('home');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'HomeController@index')->name('register');
Route::post('register', 'HomeController@index');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

