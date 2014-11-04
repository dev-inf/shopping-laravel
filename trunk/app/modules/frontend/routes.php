<?php
Route::group(array('before' => 'cache', 'after' => 'cache'), function()
{
	Route::get('/', array('as' => '/', 'uses' => 'App\Modules\Frontend\Controllers\HomeController@index'));
	
	Route::get('/film/{id}-{title}.html', array(
		'as' => 'film', 
		'uses' => 'App\Modules\Frontend\Controllers\FilmController@detail'
	))->where('id', '[0-9]+');
	
	Route::get('/{cata_url}/{id}-{fullname_url}.html', array(
		'as' => 'position', 
		'uses' => 'App\Modules\Frontend\Controllers\PositionController@detail'
	))->where('id', '[0-9]+');

	Route::get('/{url}.html', array(
		'as' => 'positionAll', 
		'uses' => 'App\Modules\Frontend\Controllers\PositionController@show'
	));
	
	Route::get('/{id}.{url}.html', array(
		'as' => 'catalogue', 
		'uses' => 'App\Modules\Frontend\Controllers\CatalogueController@show'
	));

	Route::post('/film/get-subtitle-film', array('uses' => 'App\Modules\Frontend\Controllers\FilmController@getSubtitleFilm'));

	Route::controller('customers', 'App\Modules\Frontend\Controllers\CustomersController', ['getShow' => 'customers.show']);
});