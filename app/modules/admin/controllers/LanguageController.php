<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-06
 * Description: Class Languague
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Language as LanguageModel;

class LanguageController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new LanguageModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::language.list');
	}

	public function modify($id){
		$language = '';

		if($id != ''){
			$language = LanguageModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($language == ''){
				$language = new LanguageModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:language,name,' . $id,
				'code' => 'required|unique:language,code',
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$language->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::language.form', array('language' => $language, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$language->created_by = \Auth::admin()->user()->id;
					$language->updated_by = \Auth::admin()->user()->id;
				}else{
					$language->updated_by = \Auth::admin()->user()->id;
				}
				$language->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $language->id);
				}
				return \Redirect::route('language.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::language.form', array('language' => $language, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$language = new LanguageModel;
		$language = $language->getExportData($params);
		\Functions::export($language);
		die;
	}
}