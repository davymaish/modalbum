<?php

/*Album*/
Route::get('a/{hash}', 'Public\AlbumController@album');

/*Photo*/
Route::get('i/{hash}', 'Public\ImagesController@image');
Route::get('i/t/{hash}', 'Public\ImagesController@thumbnail');

/*Videos*/
Route::get('v/{id}', 'Public\VideosController@video');
Route::get('v/t/{id}', 'Public\VideosController@torrent');
Route::get('v/p/{id}-{iid}.png', 'Public\VideosController@imageFile');
Route::get('v/f/{id}', 'Public\VideosController@videoFile');

/*Live Tv*/
Route::get('tv/{id}', 'Public\LiveTvController@tv');