<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Catalogue of Film
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\CatalogueFilm as CatalogueFilmModel;

class CatalogueFilmController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new CatalogueFilmModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::catalogueFilm.list');
	}

	public function modify($id){
		$catalogueFilm = '';
		
		if($id != ''){
			$catalogueFilm = CatalogueFilmModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($catalogueFilm == ''){
				$catalogueFilm = new CatalogueFilmModel;
			}
			$data = \Input::get();
			
			$rules = array(
				'name' => 'required|unique:catalogue_film,name,' . $id . ',id,sec_id,' . $data['sec_id']
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);
			
			foreach($data as $field => $value){
				$catalogueFilm->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::catalogueFilm.form', array('catalogueFilm' => $catalogueFilm, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$catalogueFilm->created_by = \Auth::admin()->user()->id;
					$catalogueFilm->updated_by = \Auth::admin()->user()->id;
				}else{
					$catalogueFilm->updated_by = \Auth::admin()->user()->id;
				}
				$catalogueFilm->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $catalogueFilm->id);
				}
				return \Redirect::route('catalogueFilm.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::catalogueFilm.form', array('catalogueFilm' => $catalogueFilm, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$catalogueFilm = new CatalogueFilmModel;
		$catalogueFilm = $catalogueFilm->getExportData($params);
		\Functions::export($catalogueFilm);
		die;
	}
}