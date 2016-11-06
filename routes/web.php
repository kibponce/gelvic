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
    Route::get('/add{id?}', 'ProjectOrderController@add');
    Route::post('/post', 'ProjectOrderController@post');
});

Route::group(['prefix' => 'manpower'], function () {
    Route::get('/', 'ManpowerController@index');
    Route::get('/details/{id?}', 'ManpowerController@add');
    Route::post('/post', 'ManpowerController@post');
});

Route::group(['prefix' => 'equipment'], function () {
    Route::get('/', 'EquipmentController@index');
    Route::get('/details/{id?}', 'EquipmentController@add');
    Route::post('/post', 'EquipmentController@post');
});

   