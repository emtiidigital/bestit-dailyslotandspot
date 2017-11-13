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

Route::post('/addWorker', 'SlotAndSpot@addWorker');
Route::get('worker/{id}/delete', 'SlotAndSpot@deleteWorker');

Route::get('project/{id}/delete', 'SlotAndSpot@deleteProject');
Route::post('{id}/addWorker', 'SlotAndSpot@addWorkerToProject');

Route::get('/dailySpotAndSlot', 'SlotAndSpot@dailySpotAndSlot');