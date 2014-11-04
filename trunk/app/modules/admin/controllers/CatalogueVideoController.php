<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Catalogue of Video
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\CatalogueVideo as CatalogueVideoModel;

class CatalogueVideoController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new CatalogueVideoModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::catalogueVideo.list');
	}

	public function modify($id){
		$catalogueVideo = '';

		if($id != ''){
			$catalogueVideo = CatalogueVideoModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($catalogueVideo == ''){
				$catalogueVideo = new CatalogueVideoModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:catalogue_video,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$catalogueVideo->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::catalogueVideo.form', array('catalogueVideo' => $catalogueVideo, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$catalogueVideo->created_by = \Auth::admin()->user()->id;
					$catalogueVideo->updated_by = \Auth::admin()->user()->id;
				}else{
					$catalogueVideo->updated_by = \Auth::admin()->user()->id;
				}
				$catalogueVideo->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $catalogueVideo->id);
				}
				return \Redirect::route('catalogueVideo.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::catalogueVideo.form', array('catalogueVideo' => $catalogueVideo, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$catalogueVideo = new CatalogueVideoModel;
		$catalogueVideo = $catalogueVideo->getExportData($params);
		\Functions::export($catalogueVideo);
		die;
	}
}