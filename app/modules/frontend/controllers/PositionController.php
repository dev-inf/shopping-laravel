<?php
namespace App\Modules\Frontend\Controllers;

use View,
		App\Modules\Frontend\Models\Position as PositionModel;

class PositionController extends \FrontendController{
	
	public function detail($cata_url,$id){
		if($id != ''){
			$positionModel = new PositionModel;
			$position =  $positionModel->getDetail($id);
			return View::make('frontend::position.detail',array(
				'position' => $position
			))->with('title', 'Detail Position');
		}
	}

	public function show($url){
		$positionModel = new PositionModel;
		$position =  $positionModel->getList($url);
		return View::make('frontend::position.show',array(
			'position' => $position
		))->with('title', 'List Position');
	}

}