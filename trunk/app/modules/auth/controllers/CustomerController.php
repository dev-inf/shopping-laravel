<?php
namespace App\Modules\Auth\Controllers;

use View;

class CustomerController extends \BaseController{

	public function login(){
		if(\Request::isMethod('post')){
			$data = \Input::all();
			if(\Auth::customer()->attempt(array('email' => $data['email'], 'password' => $data['password'], 'status' => 1), false)){
				// \Functions::saveLogAdmin(0);
				echo 234;die;
				return \Redirect::intended(\URL::route('home'));
			}
			if(\Request::ajax()){
				return \Response::json(array('success' => false, 'message' => 'Credetials invalid'), 400);
			}
			return \Redirect::back()->withErrors(array(
    		"error" => "Credentials invalid."
    	));
		}
		echo 123;die;
	}

	public function logout(){
		// \Functions::saveLogAdmin(1);
		\Auth::customer()->logout();
		if(isset($_SESSION['login'])){
			unset($_SESSION['login']);
		}
		return \Redirect::route('login');
	}

}