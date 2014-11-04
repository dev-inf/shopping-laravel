<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-07-25
 * Description: Class Ribbon
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Ribbon as RibbonModel;

class RibbonController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new RibbonModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::ribbon.list');
	}

	public function modify($id){
		$ribbon = '';

		if($id != ''){
			$ribbon = RibbonModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($ribbon == ''){
				$ribbon = new RibbonModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:ribbon,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$ribbon->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::ribbon.form', array('ribbon' => $ribbon, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$ribbon->created_by = \Auth::admin()->user()->id;
					$ribbon->updated_by = \Auth::admin()->user()->id;
				}else{
					$ribbon->updated_by = \Auth::admin()->user()->id;
				}
				$ribbon->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $ribbon->id);
				}
				return \Redirect::route('ribbon.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::ribbon.form', array('ribbon' => $ribbon, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}