<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-08-04
 * Description: Class Commercial
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Commercial as CommercialModel;

class CommercialController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new CommercialModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::commercial.list');
	}

	public function modify($id){
		$commercial = '';

		if($id != ''){
			$commercial = CommercialModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($commercial == ''){
				$commercial = new CommercialModel;
			}
			$data = \Input::get();

			$rules = array(
				'banner' => 'required',
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$commercial->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::commercial.form', array('commercial' => $commercial, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$commercial->created_by = \Auth::admin()->user()->id;
					$commercial->updated_by = \Auth::admin()->user()->id;
				}else{
					$commercial->updated_by = \Auth::admin()->user()->id;
				}
				$commercial->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $commercial->id);
				}
				return \Redirect::route('commercial.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::commercial.form', array('commercial' => $commercial, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}