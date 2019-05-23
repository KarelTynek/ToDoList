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

Route::get('/', 'HomeController@index')->name('home');

// Routy pro přihlášené uživatele
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', 'UserController@profile')->name('profile');

    Route::prefix('project')->group(function () {
        Route::get('create', 'ProjectController@create')->name('createproject');
        Route::get('show/{id}', 'ProjectController@show')->name('showproject');

        Route::post('store', [
            'as' => 'project.store',
            'uses' => 'ProjectController@store',
        ]);

        Route::post('add/column', [
            'as' => 'project.column',
            'uses' => 'ProjectController@column'
        ]);
    });

    Route::prefix('column')->group(function () {
        Route::get('delete/{id}', 'ColumnController@destroy')->name('deletecolumn');
    });
});

Auth::routes();