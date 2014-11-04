<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('permission', function($route, $request)
{
	// print_r($route->getActionName());die;
	// var_dump(get_class_methods($route));
	if(Auth::admin()->guest()) return Redirect::guest(URL::route('login'));
	$role = App\Modules\Admin\Models\Roles::findOrFail(Auth::admin()->user()->role);
	if($role->name != 'superadmin'){
		if($role->name != 'admin'){
			// check privilege for user
			$mvcInfo = Functions::getCurrentInfoMVC();
			$modify_id = '';
			if($request->segment(3) == 'modify' && $request->segment(4) != ''){
				$modify_id = $request->segment(4);
			}
			$resource = $mvcInfo['module'] . ':' . $mvcInfo['controller'];
			if(!App\Modules\Admin\Models\Privileges::checkPrivilege($role->id, $resource, $mvcInfo['action'], $modify_id)){
				if($request->ajax()){
					return \Response::json(array('success' => false, 'message' => 'Access Denied!'), 302);
				}else{					
					return Redirect::guest(URL::route('login'));			
				}
			}
		}
	}else{
		$_SESSION['login']['role'] = $role->name;
	}
});

// Route::filter('isLogin', function($route, $request){
// 	if(Auth::admin()->check()){
// 		return Redirect::route('home');
// 	}
// });

