<?php

// Authentication Routes...
Auth::routes();

Route::get('/', 'DashboardController@index');
Route::get('/slotandspot', 'DashboardController@slotAndSpot');

Route::get('employees', 'EmployeesController@index')->name('employees.index');
Route::get('employees/create', 'EmployeesController@create')->name('employees.create');
Route::post('employees', 'EmployeesController@store')->name('employees.store');
Route::get('employees/{employee}', 'EmployeesController@edit')->name('employees.edit');
Route::patch('employees/{employee}', 'EmployeesController@update')->name('employees.update');
Route::delete('employees/{employee}', 'EmployeesController@destroy')->name('employees.destroy');
Route::get('projects', 'ProjectsController@index')->name('projects.index');
Route::get('projects/create', 'ProjectsController@create')->name('projects.create');
Route::post('projects', 'ProjectsController@store')->name('projects.store');
Route::patch('projects/{project}', 'ProjectsController@update')->name('projects.update');
Route::post('addEmployee/{project}', 'ProjectsController@addEmployee')->name('projects.addEmployee');
Route::get('deleteEmployee/{project}/{employee}', 'ProjectsController@deleteEmployee')->name('projects.deleteEmployee');
Route::get('projects/{project}', 'ProjectsController@edit')->name('projects.edit');
Route::delete('projects/{project}', 'ProjectsController@destroy')->name('projects.destroy');
