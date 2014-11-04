<?php
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Roles as RolesModel,
	App\Modules\Admin\Models\Gender as GenderModel,
	App\Modules\Admin\Models\Users as UsersModel;

class CustomersController extends \BaseController{

	public function register(){
		$data = \Input::get();
		$rules = array(
				'username' => 'required|unique:users,username',
				'password' => 'required',
				'email' => 'required|unique:users,email',
			);

		$data['password'] = \Hash::make($data['password']);

		$validator = \Validator::make($data, $rules);
	}
	
}