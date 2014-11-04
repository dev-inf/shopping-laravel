<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', function()
//{
//	return View::make('hello');
//});

if(\Registry::get('openWebsite') == 1){
	Route::get('/', array('as' => '/', 'uses' => 'App\Modules\Frontend\Controllers\HomeController@show'));
}else{
	Route::get('/', array('as' => '/', 'uses' => 'App\Modules\Maintenance\Controllers\IndexController@index'));
}
