<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Film Subtitle
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\SectionFilm as SectionFilmModel,
	App\Modules\Admin\Models\Film as FilmModel,
	App\Modules\Admin\Models\FilmEp as FilmEpModel,
	App\Modules\Admin\Models\FilmSubtitle as FilmSubtitleModel,
	App\Modules\Admin\Models\Language as LanguageModel;

class FilmSubtitleController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmSubtitleModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::filmSubtitle.list');
	}

	public function modify($id){
		$filmSubtitle = '';

		if($id != ''){
			$filmSubtitle = FilmSubtitleModel::findOrFail($id);
		}

		$sectionFilms = SectionFilmModel::all();
		
		$tmp_sectionFilm[0] = 'Choose Section';
		foreach($sectionFilms as $section){
			$tmp_sectionFilm[$section['id']] = $section['name'];
		}
		$sectionFilm = $tmp_sectionFilm;
		unset($tmp_sectionFilm);

		$languages = LanguageModel::all();
		
		$tmp_language[0] = 'Choose Language';
		foreach($languages as $lang){
			$tmp_language[$lang['id']] = $lang['code'];
		}
		$language = $tmp_language;
		unset($tmp_language);

		if(\Request::isMethod('post')){
			if($filmSubtitle == ''){
				$filmSubtitle = new FilmSubtitleModel;
			}
			$data = \Input::get();

			$rules = array(
				'lang_id' => 'required|unique:film_subtitle,lang_id,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$filmSubtitle->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::filmSubtitle.form', array('filmSubtitle' => $filmSubtitle, 'sectionFilm' => $sectionFilm, 'language' => $language, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				$filmSubtitle->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $filmSubtitle->id);
				}
				return \Redirect::route('filmSubtitle.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::filmSubtitle.form', array('filmSubtitle' => $filmSubtitle, 'sectionFilm' => $sectionFilm, 'language' => $language, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postExport(){
		$params = \Input::get();
		$filmSubtitle = new FilmSubtitleModel;
		$filmSubtitle = $filmSubtitle->getExportData($params);
		\Functions::export($filmSubtitle);
		die;
	}
}