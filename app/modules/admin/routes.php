<?php

// FILTERS
Route::filter('csrf', function(){
	if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT'){
		if(Session::token() != Input::get('_token')){
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
});


// Url: dashboard/controller/method/params - REFERENCE LATER
// Route::any('(:bundle)/(:any)/(:any?)/(:all?)', function($controller, $method = null, $rest = null){
// 	$params = $rest ? explode('/', $rest) : array();
// 	$method = $method ? str_replace('-', '_', $method) : 'index';

// 	return Controller::call("dashboard::{$controller}@{$method}", $params);
// });
// Route::get('resources', array('as' => 'resources', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@showResources'));
Route::group(array('prefix' => 'admin', 'before' => 'permission'), function(){
	// Home Section
	Route::get('/', array('as' => 'home', 'uses' => 'App\Modules\Admin\Controllers\HomeController@index'));

	// Users Section
	Route::controller('users', 'App\Modules\Admin\Controllers\UsersController', ['getShow' => 'users.show', 'getModify' => 'users.modify']);

	// Pages Section
	Route::controller('pages', 'App\Modules\Admin\Controllers\PagesController', ['getShow' => 'pages.show', 'getModify' => 'pages.modify']);

	/* Created | 2014-06-05 | Hà Phan Minh | Gender */
	Route::controller('gender', 'App\Modules\Admin\Controllers\GenderController', ['getShow' => 'gender.show', 'getModify' => 'gender.modify']);

	// Route::controller('users', 'App\Modules\Admin\Controllers\UsersController', ['getShow' => 'users.show', 'getModify' => 'users.modify']);
	// Route::get('/admin/users', array('as' => 'users', 'uses' => 'App\Modules\Admin\Controllers\UsersController@show'));
	// // Route::get('/admin/users/edit/{id?}', function($id = ''){echo $id;die;});//array('as' => 'edit_user', 'uses' > 'App\Modules\Admin\Controllers\UsersController@edit'));
	// Route::get('/admin/users/edit/{id?}', array('as' => 'edit_user', 'uses' => 'App\Modules\Admin\Controllers\UsersController@edit'));

	// Media Section
	Route::controller('medias', 'App\Modules\Admin\Controllers\MediasController', ['getIndex' => 'medias.index']);
	
	/* Created | 2014-06-04 | Hà Phan Minh | Section of Film */
	Route::controller('sectionFilm', 'App\Modules\Admin\Controllers\SectionFilmController', ['getShow' => 'sectionFilm.show', 'getModify' => 'sectionFilm.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Catalogue of Film */
	Route::controller('catalogueFilm', 'App\Modules\Admin\Controllers\CatalogueFilmController', ['getShow' => 'catalogueFilm.show', 'getModify' => 'catalogueFilm.modify', 'getCatalogueBySection' => 'catalogueFilm.test']);
	/* Created | 2014-06-05 | Hà Phan Minh | Film */
	Route::controller('film', 'App\Modules\Admin\Controllers\FilmController', ['getShowMovie' => 'film.showMovie', 'getShowDrama' => 'film.showDrama', 'getModify' => 'film.modify']);
	Route::controller('filmMovie', 'App\Modules\Admin\Controllers\FilmController', ['getModify' => 'filmMovie.modify']);
	Route::controller('filmDrama', 'App\Modules\Admin\Controllers\FilmController', ['getModify' => 'filmDrama.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Film Ep */
	Route::controller('filmEp', 'App\Modules\Admin\Controllers\FilmEpController', ['getShow' => 'filmEp.show', 'getModify' => 'filmEp.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Film Subtitle */
	Route::controller('filmSubtitle', 'App\Modules\Admin\Controllers\FilmSubtitleController', ['getShow' => 'filmSubtitle.show', 'getModify' => 'filmSubtitle.modify']);
	/* Created | 2014-06-19 | Hà Phan Minh | Film Quanlity */
	Route::controller('filmQuality', 'App\Modules\Admin\Controllers\FilmQualityController', ['getShow' => 'filmQuality.show', 'getModify' => 'filmQuality.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Film Access */
	Route::controller('filmAccess', 'App\Modules\Admin\Controllers\FilmAccessController', ['getShow' => 'filmAccess.show', 'getModify' => 'filmAccess.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Catalogue of Position */
	Route::controller('cataloguePosition', 'App\Modules\Admin\Controllers\CataloguePositionController', ['getShow' => 'cataloguePosition.show', 'getModify' => 'cataloguePosition.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Position */
	Route::controller('position', 'App\Modules\Admin\Controllers\PositionController', ['getShow' => 'position.show', 'getModify' => 'position.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Catalogue of Video */
	Route::controller('catalogueVideo', 'App\Modules\Admin\Controllers\CatalogueVideoController', ['getShow' => 'catalogueVideo.show', 'getModify' => 'catalogueVideo.modify']);
	/* Created | 2014-06-05 | Hà Phan Minh | Video */
	Route::controller('video', 'App\Modules\Admin\Controllers\VideoController', ['getShow' => 'video.show', 'getModify' => 'video.modify']);
	/* Created | 2014-06-06 | Hà Phan Minh | Language */
	Route::controller('language', 'App\Modules\Admin\Controllers\LanguageController', ['getShow' => 'language.show', 'getModify' => 'language.modify']);
	/* Created | 2014-06-20 | Hà Phan Minh | Data */
	Route::controller('data', 'App\Modules\Admin\Controllers\DataController');
	/* Created | 2014-07-06 | Hà Phan Minh | Configuration */
	Route::controller('configuration', 'App\Modules\Admin\Controllers\ConfigurationController', ['getShow' => 'configuration.show', 'getModify' => 'configuration.modify']);
	/* Created | 2014-07-18 | Hà Phan Minh | Log */
	Route::controller('log', 'App\Modules\Admin\Controllers\LogController', ['getShow' => 'log.show']);
	/* Created | 2014-07-21 | Hà Phan Minh | Tags */
	Route::controller('tags', 'App\Modules\Admin\Controllers\TagsController', ['getShow' => 'tags.show', 'getModify' => 'tags.modify']);
	/* Created | 2014-07-25 | Hà Phan Minh | Ribbon */
	Route::controller('ribbon', 'App\Modules\Admin\Controllers\RibbonController', ['getShow' => 'ribbon.show', 'getModify' => 'ribbon.modify']);
	/* Created | 2014-08-04 | Hà Phan Minh | Event */
	Route::controller('events', 'App\Modules\Admin\Controllers\EventController', ['getShow' => 'events.show', 'getModify' => 'events.modify']);
	/* Created | 2014-08-04 | Hà Phan Minh | Commercial */
	Route::controller('commercial', 'App\Modules\Admin\Controllers\CommercialController', ['getShow' => 'commercial.show', 'getModify' => 'commercial.modify']);
	
// Permission Section
		/* Roles */
	Route::get('permissions/delete', array('as' => 'delete_permissions', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@getDelete'));
	Route::group(array('prefix' => 'permissions'), function(){
		Route::get('roles/show', array('as' => 'roles', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@showRoles'));
		Route::get('roles/modify/{id?}', array('as' => 'modify_role', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@modifyRole'));
		Route::post('roles/modify/{id?}', array('as' => 'modify_role.post', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@modifyRole'));
		Route::get('roles/delete/{id?}', array('as' => 'delete_role', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@deleteRole'));
		Route::get('roles/grant-access/{id?}', array('as' => 'grant_access_for_role', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@grantAccessForRole'));
		Route::get('roles/get-resources-by-parent/{id?}', array('as' => 'grant_access_for_role', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@getResourcesByParent'));

			/* Resources */
		Route::get('resources/show', array('as' => 'resources', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@showResources'));
		Route::get('resources/modify/{id?}', array('as' => 'modify_resource', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@modifyResource'));
		Route::post('resources/modify/{id?}', array('as' => 'modify_resource.post', 'uses' => 'App\Modules\Admin\Controllers\PermissionsController@modifyResource'));
		// Route::get('/admin/users/edit/{id?}', function($id = ''){echo $id;die;});//array('as' => 'edit_user', 'uses' > 'App\Modules\Admin\Controllers\UsersController@edit'));
		// Route::get('/admin/users/edit/{id?}', array('as' => 'edit_user', 'uses' => 'App\Modules\Admin\Controllers\UsersController@edit'));
	});
});