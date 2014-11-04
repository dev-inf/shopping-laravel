<?php
namespace App\Modules\Admin\Controllers;

use View;

class HomeController extends \BaseController{

	public function index(){
		return View::make('admin::home.index');
	}

}