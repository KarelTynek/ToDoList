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
        Route::get('edit/{id}', 'ProjectController@editIndex')->name('editproject');
        Route::get('share/delete/{email}', 'ProjectController@shareDelete')->name('sharedelete');

        Route::post('store', [
            'as' => 'project.store',
            'uses' => 'ProjectController@store',
        ]);

        Route::post('share', [
            'as' => 'project.share',
            'uses' => 'ProjectController@share'
        ]);

        Route::delete('delete', [
            'as' => 'project.delete',
            'uses' => 'ProjectController@destroy'
        ]);

        Route::post('edit', [
            'as' => 'project.edit',
            'uses' => 'ProjectController@edit'
        ]);

    });

    Route::prefix('column')->group(function () {
       Route::get('reload', 'ColumnController@reload')->name('reload');

       Route::post('add', [
            'as' => 'column.add',
            'uses' => 'ColumnController@add'
       ]);

       Route::post('rename', [
            'as' => 'column.rename',
            'uses' => 'ColumnController@rename'
       ]);

       Route::delete('delete', [
            'as' => 'column.delete',
            'uses' => 'ColumnController@destroy'
       ]);
    });

    Route::prefix('row')->group(function () {

        Route::post('add', [
            'as' => 'row.add',
            'uses' => 'RowController@add'
        ]);

        Route::post('edit', [
            'as' => 'row.edit',
            'uses' => 'RowController@edit'
        ]);

        Route::delete('delete', [
            'as' => 'row.delete',
            'uses' => 'RowController@destroy'
       ]);
 
     });
});

Auth::routes();