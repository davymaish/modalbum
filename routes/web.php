<?php

Auth::routes();
Route::get('/', 'Public\HomeController@index')->name('home');

/*Profile*/
Route::get('activate/{token}', 'Auth\ActivationController@activate');

/*Auth User*/
Route::group(['prefix' => 'my','middleware' => 'auth'], function () {

    /*My Uploads*/
    Route::get('/', 'User\DashboardController@index');

    /*My Albums*/
    Route::get('albums', 'User\AlbumController@index');
    Route::get('album/create', 'User\AlbumController@create');
    Route::post('album/store', 'User\AlbumController@store');
    Route::get('album/edit/{id}', 'User\AlbumController@edit');
    Route::post('album/update/{id}', 'User\AlbumController@update');
    Route::delete('album/delete', 'User\AlbumController@ajaxDelete')->middleware(['ajax']);

    /*Live TV*/
    Route::get('livetvs', 'User\LiveTvController@index');
    Route::get('livetvs/create', 'User\LiveTvController@create');
    Route::post('livetvs/store', 'User\LiveTvController@store');
    Route::get('livetvs/edit/{id}', 'User\LiveTvController@edit');
    Route::post('livetvs/update/{id}', 'User\LiveTvController@update');
    Route::delete('livetvs/destroy/{id}', 'User\LiveTvController@destroy');

    /*My Images*/
    Route::get('images', 'User\ImageController@index');
    Route::get('image/upload', 'User\ImageController@upload');
    Route::post('image/create', 'User\ImageController@create');
    Route::post('image/upload', 'User\ImageController@ajaxUpload')->middleware(['ajax']);
    Route::delete('image/delete', 'User\ImageController@ajaxDelete')->middleware(['ajax']);

    /*My Videos*/
    Route::get('videos', 'User\VideoController@index');
    Route::get('video/upload', 'User\VideoController@upload');
    Route::post('video/upload', 'User\VideoController@ajaxUpload')->middleware(['ajax']);
    Route::post('video/upload/done', 'User\VideoController@ajaxDone')->middleware(['ajax']);
    Route::delete('video/delete/{id}', 'User\VideoController@ajaxDelete')->middleware(['ajax']);
    Route::post('video/create', 'User\VideoController@create');
});


