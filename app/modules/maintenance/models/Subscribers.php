<?php
namespace App\Modules\Maintenance\Models;

// use App\Modules\Admin\Models\Roles as Roles;

class Subscribers extends \Eloquent{

	protected $table = 'subscribers';

	public function __construct(){
		parent::__construct();
	}

}