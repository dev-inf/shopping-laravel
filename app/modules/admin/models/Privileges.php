<?php
namespace App\Modules\Admin\Models;

use App\Modules\Admin\Models\Roles as RolesModel,
		App\Modules\Admin\Models\Resources as ResourcesModel;

class Privileges extends \Eloquent{

	protected $table = 'privileges';
	public $timestamps = false;

	public function __construct(){
		parent::__construct();
		// $this->table = \DB::getTablePrefix() . 'roles';
	}

	// public function parent(){
	// 	return $this->belongsTo(new Roles, 'parent');
	// }

	// public function children(){
	// 	return $this->hasMany(new Roles, 'parent');
	// }

	// public function users(){
	// 	return $this->hasMany(new Users, 'role');
	// }

	public function delete(){
		$users = $this->users()->get();
		foreach($users as $user){
			$user->role = null;
			$user->save();
		}
		return parent::delete();
	}

	static function checkPrivilege($role_id, $resource_name, $action, $modify_id = ''){
		if(substr($action, 0, 3) == 'get'){
			$action = strtolower(substr($action, 3));
		}
		if(substr($action, 0, 4) == 'post'){
			$action = strtolower(substr($action, 4));
		}
		if($action == 'modify'){
			if($modify_id != ''){
				$action = 'edit';
			}else{
				$action = 'add';
			}
		}
		$resource = ResourcesModel::where('name', '=', $resource_name)->where('action', '=', $action)->first();
		$resource_id = $resource->id;
		$privilege = self::where('role_id', '=', $role_id)->where('resource_id', '=', $resource_id)->first();
		if($privilege != null){
			return true;
		}else{
			return false;
		}
	}

}