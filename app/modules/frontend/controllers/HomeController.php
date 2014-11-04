<?php
namespace App\Modules\Frontend\Controllers;

use View;

class HomeController extends \FrontendController{
	public function show(){
		return View::make('frontend::home.show')->with('title', 'Kho Phim Beta');
	}

}