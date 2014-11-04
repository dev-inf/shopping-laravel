<?php
namespace App\Modules\Frontend\Controllers;

use View,
	App\Modules\Admin\Models\Roles as RolesModel,
	App\Modules\Admin\Models\Gender as GenderModel,
	App\Modules\Admin\Models\Users as UsersModel;

class CustomersController extends \FrontendController{

	public function getShow(){
		if(empty($_GET)){
			$config = \Config::get('custom/hybrid_auth');
			$config['base_url'] = 'http://dev.khophimhd.vn/vendor/hybridauth/hybridauth/hybridauth/index.php';
			$socialAuth = new \Hybrid_Auth($config);
			$facebook = $socialAuth->authenticate('Facebook');
			echo gettype($facebook->getUserProfile());
		}
		die;
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new UsersModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		$roles = RolesModel::where('id', '!=', '1')->get();

		foreach($roles as $role){
			$all_roles[$role->id] = $role->name;
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::user.list', array('all_roles' => $all_roles));
	}

	public function modify($id){
		$user = '';
		$roles = RolesModel::where('id', '!=', '1')->get();

		foreach($roles as $role){
			$tmp_role[$role['id']] = $role['name'];
		}
		$roles = $tmp_role;
		unset($tmp_role);
		
		$genders = GenderModel::all();

		foreach($genders as $gender){
			$tmp_gender[$gender['id']] = $gender['name'];
		}
		$genders = $tmp_gender;
		unset($tmp_gender);

		if($id != ''){
			$user = UsersModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($user == ''){
				$user = new UsersModel;
			}
			$data = \Input::get();

			$rules = array(
				'username' => 'required|unique:users,username,' . $id,
				'password' => 'required',
				'email' => 'required|unique:users,email,' . $id . '|email',
			);

			if($id != ''){
				unset($rules['password']);
			}

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);
			unset($data['confirm_password']);

			foreach($data as $field => $value){
				if($field == 'password' && $value != ''){
					$value = \Hash::make($value);
				}

				if($field == 'password' && $value == '' && $id != ''){
					continue;
				}
				
				$user->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::user.form', array('user' => $user, 'id' => $id, 'roles' => $roles, 'gender' => $genders, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$user->created_by = \Auth::admin()->user()->id;
					$user->updated_by = \Auth::admin()->user()->id;
				}else{
					$user->updated_by = \Auth::admin()->user()->id;
				}
				$user->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $user->id);
				}
				return \Redirect::route('users.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::user.form', array('user' => $user, 'id' => $id, 'roles' => $roles, 'gender' => $genders));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$users = new UsersModel;
		$users = $users->getExportData($params);
		
		\Functions::export($users);
		die;
	}
	
}