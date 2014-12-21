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


// Language
Breadcrumbs::register('language.show', function($breadcrumbs){
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Language Manager', URL::action('App\Modules\Admin\Controllers\LanguageController@getShow'));
});