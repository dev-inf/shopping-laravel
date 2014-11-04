<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Catalogue of Position
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\CataloguePosition as CataloguePositionModel;

class CataloguePositionController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new CataloguePositionModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::cataloguePosition.list');
	}

	public function modify($id){
		$cataloguePosition = '';

		if($id != ''){
			$cataloguePosition = CataloguePositionModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($cataloguePosition == ''){
				$cataloguePosition = new CataloguePositionModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:catalogue_position,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$cataloguePosition->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::cataloguePosition.form', array('cataloguePosition' => $cataloguePosition, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$cataloguePosition->created_by = \Auth::admin()->user()->id;
					$cataloguePosition->updated_by = \Auth::admin()->user()->id;
				}else{
					$cataloguePosition->updated_by = \Auth::admin()->user()->id;
				}
				$cataloguePosition->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $cataloguePosition->id);
				}
				return \Redirect::route('cataloguePosition.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::cataloguePosition.form', array('cataloguePosition' => $cataloguePosition, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$cataloguePosition = new CataloguePositionModel;
		$cataloguePosition = $cataloguePosition->getExportData($params);
		\Functions::export($cataloguePosition);
		die;
	}
}