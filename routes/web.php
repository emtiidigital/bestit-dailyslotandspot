<?php

// Authentication Routes...
Auth::routes();

Route::get('/', 'DashboardController@index');

Route::get('employees', 'EmployeesController@index')->name('employees.index');
Route::get('employees/create', 'EmployeesController@create')->name('employees.create');
Route::post('employees', 'EmployeesController@store')->name('employees.store');
Route::patch('employees/{employee}', 'EmployeesController@update')->name('employees.update');
Route::delete('EmployeesController/{employee}', 'EmployeesController@destroy')->name('employees.destroy');

Route::post('/addWorker', 'SlotAndSpot@addWorker')->middleware('auth');
Route::post('/addProject', 'SlotAndSpot@addProject')->middleware('auth');
Route::get('worker/{id}/delete', 'SlotAndSpot@deleteWorker')->middleware('auth');

Route::get('project/{id}/delete', 'SlotAndSpot@deleteProject')->middleware('auth');
Route::post('{id}/addWorker', 'SlotAndSpot@addWorkerToProject')->middleware('auth');
Route::get('{id}/deleteWorker/{workerId}', 'SlotAndSpot@deleteWorkerFromProject')->middleware('auth');

Route::get('/dailySpotAndSlot', 'SlotAndSpot@dailySpotAndSlot');