<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-19
 * Description: Class Quality of Film
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\FilmQuality as FilmQualityModel;

class FilmQualityController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmQualityModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::filmQuality.list');
	}

	public function modify($id){
		$filmQuality = '';

		if($id != ''){
			$filmQuality = FilmQualityModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($filmQuality == ''){
				$filmQuality = new FilmQualityModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:film_quality,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$filmQuality->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::filmQuality.form', array('filmQuality' => $filmQuality, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$filmQuality->created_by = \Auth::admin()->user()->id;
					$filmQuality->updated_by = \Auth::admin()->user()->id;
				}else{
					$filmQuality->updated_by = \Auth::admin()->user()->id;
				}
				$filmQuality->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $filmQuality->id);
				}
				return \Redirect::route('filmQuality.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::filmQuality.form', array('filmQuality' => $filmQuality, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$filmQuality = new FilmQualityModel;
		$filmQuality = $filmQuality->getExportData($params);
		\Functions::export($filmQuality);
		die;
	}
}