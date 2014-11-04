<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-07-18
 * Description: Class Log
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Log as LogModel;

class LogController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new LogModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		return View::make('admin::log.list');
	}
}