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

Route::get('/', 'AppController@index');

Route::group(['prefix' => 'project-order'], function () {
    Route::get('/', 'ProjectOrderController@index');
    Route::get('/add/{id?}', 'ProjectOrderController@add');
    Route::post('/post', 'ProjectOrderController@post');
    Route::get('/show/{id?}', 'ProjectOrderController@show');
    Route::post('/generateDaily/', 'ProjectOrderController@generateDaily');
    Route::get('/daily/{po_daily_id?}', 'ProjectOrderController@showProjectDaily');
    Route::get('/assign-manpower/{po_id?}/{manpower_id?}', 'ProjectOrderController@assignManpowerToProject');
    Route::get('/delete-manpower/{id?}', 'ProjectOrderController@deleteManpowerFromProject');
    Route::get('/assign-daily-manpower/{po_daily_id?}/{manpower_id}', 'ProjectOrderController@assignManpowerToProjectDaily');
    Route::post('/daily-log/', 'ProjectOrderController@postManpowerDailyLog');
    Route::post('/update-daily-activty/', 'ProjectOrderController@updateActivity');
    Route::get('/delete-daily-manpower/{id?}/{po_daily_id?}', 'ProjectOrderController@deleteDailyManpower');
});

Route::group(['prefix' => 'materials'], function () {
    Route::post('/post', 'MaterialsController@post');
    Route::get('/delete/{id?}/{po_id?}', 'MaterialsController@delete');
});

Route::group(['prefix' => 'manpower'], function () {
    Route::get('/', 'ManpowerController@index');
    Route::get('/add/{id?}', 'ManpowerController@add');
    Route::post('/post', 'ManpowerController@post');
});

Route::group(['prefix' => 'equipment'], function () {
    Route::get('/', 'EquipmentController@index');
    Route::get('/add/{id?}', 'EquipmentController@add');
    Route::post('/post', 'EquipmentController@post');
});

   