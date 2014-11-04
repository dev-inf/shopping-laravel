<?php
namespace App\Modules\Admin\Models;

class Roles extends \Eloquent{

	protected $table = 'roles';
	public $timestamps = false;

	public function __construct(){
		parent::__construct();
		// $this->table = \DB::getTablePrefix() . 'roles';
	}

	public function parent(){
		return $this->belongsTo(new Roles, 'parent');
	}

	public function children(){
		return $this->hasMany(new Roles, 'parent');
	}

	public function users(){
		return $this->hasMany(new Users, 'role');
	}

	public function delete(){
		$users = $this->users()->get();
		foreach($users as $user){
			$user->role = null;
			$user->save();
		}
		return parent::delete();
	}

}