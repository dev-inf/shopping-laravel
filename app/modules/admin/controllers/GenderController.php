<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Gender of Film
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Gender as GenderModel;

class GenderController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new GenderModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::gender.list');
	}

	public function modify($id){
		$gender = '';
		if($id != ''){
			$gender = GenderModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($gender == ''){
				$gender = new GenderModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:gender,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$gender->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::gender.form', array('gender' => $gender, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{

				if($id == ''){
					$gender->created_by = \Auth::admin()->user()->id;
					$gender->updated_by = \Auth::admin()->user()->id;
				}else{
					$gender->updated_by = \Auth::admin()->user()->id;
				}
				$gender->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $gender->id);
				}
				return \Redirect::route('gender.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}
		return View::make('admin::gender.form', array('gender' => $gender, 'id' => $id));
	}

	public function postExport(){
		$params = \Input::get();
		$gender = new GenderModel;
		$gender = $gender->getExportData($params);
		\Functions::export($gender);
		die;
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}