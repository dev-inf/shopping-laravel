<?php
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Roles as RolesModel,
	App\Modules\Admin\Models\Users as UsersModel;

class MediasController extends \BaseController{

	public function getIndex(){
		return View::make('admin::medias.index');
	}

	
}