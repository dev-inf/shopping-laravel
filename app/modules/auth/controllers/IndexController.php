<?php
namespace App\Modules\Auth\Controllers;

use View;

class IndexController extends \BaseController{

	public function login(){
//        $2y$10$lSJpsP0HRl1q5Gvsw00WyuLxF9.uGMy8Va7KnTxIEnRMfMIwYMVla
//        echo \Hash::make(123456);die;
		if(\Request::isMethod('post')){
			$data = \Input::all();
			if(\Auth::admin()->attempt(array('username' => $data['username'], 'password' => $data['password'], 'status' => 1), false)){
				\Functions::saveLogAdmin(0);
				return \Redirect::intended(\URL::route('home'));
			}

			return \Redirect::back()->withErrors(array(
    		"error" => "Credentials invalid."
    	));
		}
		return View::make('auth::index.login');
	}

	public function logout(){
		\Functions::saveLogAdmin(1);
		\Auth::admin()->logout();
		if(isset($_SESSION['login'])){
			unset($_SESSION['login']);
		}
		return \Redirect::route('login');
	}

}