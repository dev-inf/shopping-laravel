<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-04
 * Description: Class Section of Film
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\SectionFilm as SectionFilmModel;

class SectionFilmController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new SectionFilmModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::sectionFilm.list');
	}

	public function modify($id){
		$sectionFilm = '';

		if($id != ''){
			$sectionFilm = SectionFilmModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($sectionFilm == ''){
				$sectionFilm = new SectionFilmModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:section_film,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$sectionFilm->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::sectionFilm.form', array('sectionFilm' => $sectionFilm, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$sectionFilm->created_by = \Auth::admin()->user()->id;
					$sectionFilm->updated_by = \Auth::admin()->user()->id;
				}else{
					$sectionFilm->updated_by = \Auth::admin()->user()->id;
				}
				$sectionFilm->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $sectionFilm->id);
				}
				return \Redirect::route('sectionFilm.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::sectionFilm.form', array('sectionFilm' => $sectionFilm, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$sectionFilm = new SectionFilmModel;
		$sectionFilm = $sectionFilm->getExportData($params);
		\Functions::export($sectionFilm);
		die;
	}
}