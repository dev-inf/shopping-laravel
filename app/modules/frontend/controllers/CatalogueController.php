<?php
namespace App\Modules\Frontend\Controllers;

use View,
		App\Modules\Frontend\Models\Catalogue as CatalogueModel;

class CatalogueController extends \FrontendController{

	public function show($id,$url){
		$catalogueModel = new CatalogueModel;
		$film =  $catalogueModel->getList($id,$url);
		return View::make('frontend::catalogue.show',array(
			'film' => $film
		))->with('title', 'List Film');
	}

}