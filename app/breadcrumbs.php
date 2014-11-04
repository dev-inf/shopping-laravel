<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs){
	$breadcrumbs->push('Home', route('home'));
});


// Users
Breadcrumbs::register('users.show', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('User', URL::action('App\Modules\Admin\Controllers\UsersController@getShow'));
});

Breadcrumbs::register('users.modify', function($breadcrumbs){
	$breadcrumbs->parent('users.show');
	$breadcrumbs->push('Modify');
});

// Pages
Breadcrumbs::register('pages.show', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Page', URL::action('App\Modules\Admin\Controllers\PagesController@getShow'));
});

Breadcrumbs::register('pages.modify', function($breadcrumbs){
	$breadcrumbs->parent('pages.show');
	$breadcrumbs->push('Modify');
});

// Permission
	/* Roles */
Breadcrumbs::register('admin.permissions.roles.showRoles', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Role', route('roles'));
});
// Breadcrumbs::register('roles', function($breadcrumbs){
// 	$breadcrumbs->parent('home');
// 	$breadcrumbs->push('Role', route('roles'));
// });

// Breadcrumbs::register('modify_role', function($breadcrumbs){
// 	$breadcrumbs->parent('roles');
// 	$breadcrumbs->push('Modify Role', route('modify_role'));
// });
// Breadcrumbs::register('modify_role.post', function($breadcrumbs){
// 	$breadcrumbs->parent('roles');
// 	$breadcrumbs->push('Modify Role', route('modify_role.post'));
// });

// Breadcrumbs::register('grant_access_for_role', function($breadcrumbs){
// 	$breadcrumbs->parent('roles');
// 	$breadcrumbs->push('Grant Access', route('grant_access_for_role'));
// });

// 	/* Resources */
// Breadcrumbs::register('resources', function($breadcrumbs){
// 	$breadcrumbs->parent('home');
// 	$breadcrumbs->push('Resource', route('resources'));
// });

// Breadcrumbs::register('modify_resource', function($breadcrumbs){
// 	$breadcrumbs->parent('resources');
// 	$breadcrumbs->push('Modify Resource', route('modify_resource'));
// });
// Breadcrumbs::register('modify_resource.post', function($breadcrumbs){
// 	$breadcrumbs->parent('resources');
// 	$breadcrumbs->push('Modify Resource', route('modify_resource.post'));
// });

/* Update | Hà Phan Minh | 2014-06-06 */
// Film
Breadcrumbs::register('film', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Film Manager', '#');
});
	// Section Film
	Breadcrumbs::register('sectionFilm.show', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Section of Film', URL::action('App\Modules\Admin\Controllers\SectionFilmController@getShow'));
	});

	Breadcrumbs::register('sectionFilm.modify', function($breadcrumbs){
		$breadcrumbs->parent('sectionFilm.show');
		$breadcrumbs->push('Modify');
	});

	// Catalogue Film
	Breadcrumbs::register('catalogueFilm.show', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Catalogue of Film', URL::action('App\Modules\Admin\Controllers\CatalogueFilmController@getShow'));
	});

	Breadcrumbs::register('catalogueFilm.modify', function($breadcrumbs){
		$breadcrumbs->parent('catalogueFilm.show');
		$breadcrumbs->push('Modify');
	});

	// Film
	Breadcrumbs::register('film.showMovie', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Film Movie', URL::action('App\Modules\Admin\Controllers\FilmController@getShowMovie'));
	});

	Breadcrumbs::register('film.showDrama', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Film Drama', URL::action('App\Modules\Admin\Controllers\FilmController@getShowDrama'));
	});


	Breadcrumbs::register('film.modify', function($breadcrumbs){
		$breadcrumbs->parent('film.'.Session::get('previosMethod'));
		$breadcrumbs->push('Modify');
	});

	// Film Ep
	Breadcrumbs::register('filmEp.show', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List EP', URL::action('App\Modules\Admin\Controllers\FilmEpController@getShow'));
	});

	Breadcrumbs::register('filmEp.modify', function($breadcrumbs){
		$breadcrumbs->parent('filmEp.show');
		$breadcrumbs->push('Modify');
	});

	// Film Subtitle
	Breadcrumbs::register('filmSubtitle.show', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Subtitle', URL::action('App\Modules\Admin\Controllers\FilmSubtitleController@getShow'));
	});

	Breadcrumbs::register('filmSubtitle.modify', function($breadcrumbs){
		$breadcrumbs->parent('filmSubtitle.show');
		$breadcrumbs->push('Modify');
	});
	
	// Film Quality
	Breadcrumbs::register('filmQuality.show', function($breadcrumbs){
		$breadcrumbs->parent('film');
		$breadcrumbs->push('List Quality', URL::action('App\Modules\Admin\Controllers\FilmQualityController@getShow'));
	});

	Breadcrumbs::register('filmQuality.modify', function($breadcrumbs){
		$breadcrumbs->parent('filmQuality.show');
		$breadcrumbs->push('Modify');
	});

//Position
Breadcrumbs::register('position', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Position Manager', '#');
});
	// Catalogue Position
	Breadcrumbs::register('cataloguePosition.show', function($breadcrumbs){
		$breadcrumbs->parent('position');
		$breadcrumbs->push('List Catalogue of Position', URL::action('App\Modules\Admin\Controllers\CataloguePositionController@getShow'));
	});

	Breadcrumbs::register('cataloguePosition.modify', function($breadcrumbs){
		$breadcrumbs->parent('cataloguePosition.show');
		$breadcrumbs->push('Modify');
	});

	// Position
	Breadcrumbs::register('position.show', function($breadcrumbs){
		$breadcrumbs->parent('position');
		$breadcrumbs->push('List Position', URL::action('App\Modules\Admin\Controllers\PositionController@getShow'));
	});

	Breadcrumbs::register('position.modify', function($breadcrumbs){
		$breadcrumbs->parent('position.show');
		$breadcrumbs->push('Modify');
	});

// Video
Breadcrumbs::register('video', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Video Manager', '#');
});
	// Catalogue Position
	Breadcrumbs::register('catalogueVideo.show', function($breadcrumbs){
		$breadcrumbs->parent('video');
		$breadcrumbs->push('List Catalogue of Video', URL::action('App\Modules\Admin\Controllers\CatalogueVideoController@getShow'));
	});

	Breadcrumbs::register('catalogueVideo.modify', function($breadcrumbs){
		$breadcrumbs->parent('catalogueVideo.show');
		$breadcrumbs->push('Modify');
	});

	// Position
	Breadcrumbs::register('video.show', function($breadcrumbs){
		$breadcrumbs->parent('video');
		$breadcrumbs->push('List Video', URL::action('App\Modules\Admin\Controllers\VideoController@getShow'));
	});

	Breadcrumbs::register('video.modify', function($breadcrumbs){
		$breadcrumbs->parent('video.show');
		$breadcrumbs->push('Modify');
	});

// Language
Breadcrumbs::register('language.show', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Language Manager', URL::action('App\Modules\Admin\Controllers\LanguageController@getShow'));
});