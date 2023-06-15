<?php

Auth::routes();
Route::get('/', 'Public\HomeController@index')->name('home');

/*Profile*/
Route::get('activate/{token}', 'Auth\ActivationController@activate');

/*Auth User*/
Route::group(['prefix' => 'my','middleware' => 'auth'], function () {

    /*My Uploads*/
    Route::get('/', 'User\DashboardController@index');
    Route::get('albums', 'User\DashboardController@albums');
    Route::get('images', 'User\DashboardController@images');
    Route::get('videos', 'User\DashboardController@videos');

    /*Live TV*/
    Route::resource('livetvs', 'User\LiveTvController');

    /*My Images*/
    Route::get('image/upload', 'User\ImageController@index');
    Route::post('image/upload', 'User\ImageController@ajaxUpload')->middleware(['ajax']);
    Route::delete('image/delete', 'User\ImageController@ajaxDelete')->middleware(['ajax']);
    Route::post('image/create', 'User\ImageController@create');

    /*My Videos*/
    Route::get('video/upload', 'User\VideoController@index');
    Route::post('video/upload', 'User\VideoController@upload')->middleware(['ajax']);
    Route::post('video/upload/done', 'User\VideoController@videoDone')->middleware(['ajax']);
    Route::delete('video/delete/{id}', 'User\VideoController@videoDelete')->middleware(['ajax']);
    Route::post('video/create', 'User\VideoController@create');
});


