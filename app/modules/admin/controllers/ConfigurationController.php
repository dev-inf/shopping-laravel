<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-07-18
 * Description: Class Configuration
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Configuration as ConfigurationModel;

class ConfigurationController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new ConfigurationModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::configuration.list');
	}

	public function modify($id){
		$configuration = '';

		if($id != ''){
			$configuration = ConfigurationModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($configuration == ''){
				$configuration = new ConfigurationModel;
			}
			$data = \Input::get();

			$rules = array(
				'key' => 'required|unique:system_registries,key,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$configuration->{$field} = $value;
			}
			
			if($validator->fails()){
				return View::make('admin::configuration.form', array('configuration' => $configuration, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				\Registry::set($configuration->key, $configuration->value);
				$configuration->save();
				
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $configuration->id);
				}
				return \Redirect::route('configuration.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::configuration.form', array('configuration' => $configuration, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}