<?php
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Privileges as PrivilegesModel,
	App\Modules\Admin\Models\Roles as RolesModel,
	App\Modules\Admin\Models\Resources as ResourcesModel;

class PermissionsController extends \BaseController{

	/* ----- Roles ----- */
	public function showRoles(){
		// $users = \DB::select('SELECT * FROM person');
		// $route = new \Route;
		// var_dump(get_class());

		$roles = RolesModel::where('id', '!=', '1')->get();

		return View::make('admin::role.list', array('roles' => $roles));
	}

	public function modifyRole($id = ''){
		$rules = array(
			'name' => 'required|unique:roles,name,' . $id,
		);
		$role = '';
		if($id != ''){
			$role = RolesModel::findOrFail($id);			
		}

		if(\Request::isMethod('post')){
			$data = \Input::all();
			unset($data['ok']);
			unset($data['_token']);
			
			$type = 'add';
			if($data['id'] != ''){
				$type = 'edit';
			}

			switch($type){
				case 'add':
					unset($data['id']);
					$role = new RolesModel;
				break;
				case 'edit':

				break;
			}

			$validator = \Validator::make($data, $rules);
			if($validator->fails()){
				return View::make('admin::role.form', array('role' => $role, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				foreach($data as $field => $value){
					$role->{$field} = $value;
				}
				if($id == ''){
					$role->created_by = \Auth::admin()->user()->id;
					$role->updated_by = \Auth::admin()->user()->id;
				}else{
					$role->updated_by = \Auth::admin()->user()->id;
				}
				$role->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $role->id);
				}
				return \Redirect::route('roles')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();
			}

		}

		return View::make('admin::role.form', array('role' => $role, 'id' => $id));
	}

	public function deleteRole($id = ''){
		try{
			$role = RolesModel::find($id);
			$role->delete();
			return \Redirect::route('roles')->with('success', '<strong>Success! </strong>Your action is finished.');
		}catch(\Exception $e){
			return \Redirect::route('roles')->with('fail', '<strong>Fail! </strong>Something went wrong.');
		}
	}

	/* ----- Resources ----- */
	public function showResources(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new ResourcesModel;
			$response = $model->getData($params);

			return \Response::json($response, 200);
		}
		\Functions::saveLogAdmin(2);

		return View::make('admin::resource.list');
	}

	public function modifyResource($id = ''){
		$resources = ResourcesModel::where('parent', null)->get()->toArray();
		$modules[] = 'Choose Module';
		
		foreach($resources as $item){
			$modules[$item['id']] = $item['name'];
		}
		unset($resources);

		$resource = '';
		if($id != ''){
			$resource = ResourcesModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			$data = \Input::all();
			unset($data['ok']);
			unset($data['_token']);
			
			$rules = array(
				'name' => 'required|unique:resources,name,' . $id . ',id,action,' . $data['action'],
				'action' => 'unique:resources,action,' . $id . ',id,name,' . $data['name'],
			);

			$type = 'add';
			if($data['id'] != ''){
				$type = 'edit';
			}

			switch($type){
				case 'add':
					unset($data['id']);
					$resource = new ResourcesModel;
				break;
				case 'edit':

				break;
			}

			if($data['parent'] == 0){
				unset($data['parent']);
			}

			$validator = \Validator::make($data, $rules);
			if($validator->fails()){
				return View::make('admin::resource.form', array('resource' => $data, 'id' => $id, 'modules' => $modules, 'error_messages' => $validator->messages()->toArray()));
			}
			foreach($data as $field => $value){
				$resource->{$field} = $value;
			}
			$resource->save();
			return \Redirect::route('resources')->with('success', '<strong>Success! </strong>Your action is done.');

		}

		return View::make('admin::resource.form', array('resource' => $resource, 'id' => $id, 'modules' => $modules));
	}

	public function deleteResource($id = ''){
		try{
			$resource = ResourcesModel::find($id);
			$resource->delete();
			return \Redirect::route('resources')->with('success', '<strong>Success! </strong>Your action is finished.');
		}catch(\Exception $e){
			return \Redirect::route('resources')->with('fail', '<strong>Fail! </strong>Something went wrong.');
		}
	}

	/* ----- Grant Access ----- */
	public function grantAccessForRole($id = ''){
		$modules = ResourcesModel::where('parent', null)->where('name', 'LIKE', 'Admin%')->get()->toArray();
		if(\Request::ajax()){
			$data = \Input::get();
			foreach($data as $type => $values){
				foreach($values as $resource_id){
					$resource = PrivilegesModel::where('resource_id', '=', $resource_id)->where('role_id', '=', $id)->count();
					if($resource != 0 && $type == 'resources_off'){
						PrivilegesModel::where('resource_id', '=', $resource_id)->where('role_id', '=', $id)->delete();
					}
					if($resource == 0 && $type == 'resources_on'){
						$resource = new PrivilegesModel;
						$resource->role_id = $id;
						$resource->resource_id = $resource_id;
						$resource->save();
					}
				}
			}
			return \Response::json(array('success' => true), 200);
		}
		return View::make('admin::role.grant_access', array('modules' => $modules, 'role_id' => $id));
	}

	public function getResourcesByParent($id = ''){
		if(\Request::ajax()){
			$data = \Input::get();
			$modules = ResourcesModel::where('parent', $data['parent_id'])->get()->toArray();
			foreach($modules as $key => $module){
				$privilege = PrivilegesModel::where('role_id', '=', $data['role_id'])->where('resource_id', '=', $module['id'])->count();
				if($privilege != 0){
					$modules[$key]['checked'] = 'on';
				}else{
					$modules[$key]['checked'] = 'off';
				}
			}
			return \Response::json(array('success' => true, 'resources' => $modules), 200);
		}
	}

}