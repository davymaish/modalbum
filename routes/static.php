<?php

/*Images*/
Route::get('a/{hash}', 'Public\ImagesController@album');
Route::get('i/{hash}', 'Public\ImagesController@image');
Route::get('i/t/{hash}', 'Public\ImagesController@thumbnail');

/*Videos*/
Route::get('v/{id}', 'Public\VideosController@video');
Route::get('v/t/{id}', 'Public\VideosController@torrent');
Route::get('v/p/{id}-{iid}.png', 'Public\VideosController@image');

/*Live Tv*/
Route::get('tv/{id}', 'Public\LiveTvController@tv');