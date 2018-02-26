<?php

// Authentication Routes...
Auth::routes();

Route::get('/', 'DashboardController@index');
Route::get('/slotandspot', 'DashboardController@slotAndSpot')->middleware('auth');

Route::get('employees', 'EmployeesController@index')->name('employees.index')->middleware('auth');
Route::get('employees/create', 'EmployeesController@create')->name('employees.create')->middleware('auth');
Route::post('employees', 'EmployeesController@store')->name('employees.store')->middleware('auth');
Route::get('employees/{employee}', 'EmployeesController@edit')->name('employees.edit')->middleware('auth');
Route::patch('employees/{employee}', 'EmployeesController@update')->name('employees.update')->middleware('auth');
Route::delete('employees/{employee}', 'EmployeesController@destroy')->name('employees.destroy')->middleware('auth');

Route::get('projects', 'ProjectsController@index')->name('projects.index')->middleware('auth');
Route::get('projects/create', 'ProjectsController@create')->name('projects.create')->middleware('auth');
Route::post('projects', 'ProjectsController@store')->name('projects.store')->middleware('auth');
Route::get('projects/{project}', 'ProjectsController@edit')->name('projects.edit')->middleware('auth');
Route::patch('projects/{project}', 'ProjectsController@update')->name('projects.update')->middleware('auth');
Route::delete('projects/{project}', 'ProjectsController@destroy')->name('projects.destroy')->middleware('auth');
Route::post('addEmployee/{project}', 'ProjectsController@addEmployee')->name('projects.addEmployee')->middleware('auth');
Route::get('deleteEmployee/{project}/{employee}', 'ProjectsController@deleteEmployee')->name('projects.deleteEmployee')->middleware('auth');
Route::post('sendMessage/{project}', 'ProjectsController@sendMessage')->name('projects.sendMessage')->middleware('auth');

// Disable Registration Routes...
Route::get('register', 'DashboardController@index')->name('register');
Route::post('register', 'DashboardController@index');