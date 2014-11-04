<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Film Access
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\FilmAccess as FilmAccessModel;

class FilmAccessController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmAccessModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::filmAccess.list');
	}

	public function postExport(){
		$params = \Input::get();
		$filmAccess = new FilmAccessModel;
		$filmAccess = $filmAccess->getExportData($params);
		
		\Functions::export($filmAccess);
		die;
	}

}