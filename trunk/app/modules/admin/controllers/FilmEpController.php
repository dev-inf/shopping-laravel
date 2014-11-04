<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Film Ep
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\SectionFilm as SectionFilmModel,
	App\Modules\Admin\Models\Film as FilmModel,
	App\Modules\Admin\Models\FilmEp as FilmEpModel,
	App\Modules\Admin\Models\FilmSubtitle as FilmSubtitleModel,
	App\Modules\Admin\Models\FilmQuality as FilmQualityModel,
	App\Modules\Admin\Models\Language as LanguageModel;

class FilmEpController extends \BaseController{

	public function getShow($film_id = ''){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmEpModel;
			if($film_id != ''){
				$params['filter']['ep.film_id'] = array(
					'op' => '=',
					'value' => $film_id,
				);
			}
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::filmEp.list', array('film_id' => $film_id));
	}

	public function modify($id){
		$login_user = \Auth::admin()->user();
		// echo $login_user->id;die;
		$filmEpField = '';
		$language = LanguageModel::all();
		foreach($language as $lang){
			$langs[$lang->code] = $lang->id;
			$lang_codes[$lang->id] = $lang->code;
		}
		$quality_id = '';
		if($id != ''){
			$filmEpField = FilmEpModel::findOrFail($id);
			$subs = $filmEpField->fromSubs->toArray();
			foreach($subs as $sub){
				$filmEpField->{$lang_codes[$sub['lang_id']] . '_subtitle_url'} = $sub['subtitle_url'];
			}
		}

		if(@$_GET['film_id'] != ''){
			$film = FilmModel::findOrFail($_GET['film_id']);
			// $sec_id = $film->fromSection->id;
		}

		$sectionFilms = SectionFilmModel::all();
		
		$tmp_sectionFilm[0] = 'Choose Section';
		foreach($sectionFilms as $section){
			$tmp_sectionFilm[$section['id']] = $section['name'];
		}
		$sectionFilm = $tmp_sectionFilm;
		unset($tmp_sectionFilm);
		
		$filmQualitys = FilmQualityModel::all();
		
		$tmp_filmQuality[0] = 'Choose Quality';
		foreach($filmQualitys as $quality){
			$tmp_filmQuality[$quality['id']] = $quality['code'];
		}
		$filmQuality = $tmp_filmQuality;
		unset($tmp_filmQuality);
		
		// $filmSubtitle = new FilmSubtitleModel;
		$filmSubtitle = array();

		if(\Request::isMethod('post')){
			if($filmEpField == ''){
				$filmEp = new FilmEpModel;
				$filmEpField = new FilmEpModel;
				$filmEp->created_by = $login_user;
				$type = "add";
			}else{
				$filmEp = FilmEpModel::findOrFail($id);
				$filmEp->updated_by = $login_user->id;
				$type = "edit";
			}
			
			$dataSource = \Input::get();
			// echo $id . ' ' . $quality_id;die;
			$rules = array(
				'ep_link' => 'required',
				'ep' => 'required|unique:film_ep,ep,' . $id  . ',id,quality_id,' . $dataSource['quality_id'] . ',film_id,' . $dataSource['film_id'],
				'quality_id' => 'required|unique:film_ep,quality_id,' . $id  . ',id,ep,' . $dataSource['ep'] . ',film_id,' . $dataSource['film_id'],
				// 'password' => 'required',
				// 'email' => 'required|unique:users,email,' . $id . '|email',
			);
			
			$epInput = array('release_date', 'film_id', 'ep', 'ep_link', 'quality_id', 'time');
			$subInput = array('vi_subtitle_url', 'en_subtitle_url', 'cn_subtitle_url');

			$validator = \Validator::make($dataSource, $rules);

			unset($dataSource['ok']);
			unset($dataSource['_token']);

			if($validator->fails()){
				return \Response::json(array(
					'success' => false,
					'error_messages' => $validator->messages()->toArray(),
				), 400);
				// return View::make('admin::filmEp.form', array('filmEpData' => $filmEpField, 'filmQuality' => $filmQuality, 'sectionFilm' => $sectionFilm, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			$flagSub = 0;
			
			foreach($dataSource as $field => $value){
				$filmEpField->{$field} = $value;
				if($field == 'ep' && $value == ''){
					$value = 0;
				}
				if(in_array($field, $epInput)){
					if($value){
						$filmEp->{$field} = $value;
						$flagEp = 1;
					}
				}elseif(in_array($field, $subInput)){
					$fields = explode('_', $field);
					$sub_lang = array_shift($fields);
					$fields = implode('_', $fields);
					$filmSubtitle[$sub_lang] = new FilmSubtitleModel;
					$filmSubtitle[$sub_lang]->lang_id = $langs[$sub_lang];
					if($value){
						$filmSubtitle[$sub_lang]->{$fields} = $value;
						// $flagSub = 1;
					}
				}
			}

			\DB::beginTransaction();
			try{
				if($filmEp->save()){
					$idEp = $filmEp->id;
					if($type == 'add'){
						$message = 'Thêm tập phim (' . $filmEp->id . ') thành công';
					}
					if($type == 'edit'){
						$message = 'Chỉnh sửa tập phim (' . $filmEp->id . ') thành công';
					}
					// \Functions::saveLogAdmin($login_user->id, $message);
				}
				if(!empty($filmSubtitle)){
					foreach($filmSubtitle as $lang_code => $filmSub){
						FilmSubtitleModel::whereRaw('ep_id = ? AND lang_id = ?', array($idEp, $langs[$lang_code]))->delete();
						$filmSub->ep_id = $idEp;
						$filmSub->created_by = $filmEp->created_by;
						$filmSub->updated_by = $filmEp->updated_by;

						if($filmSub->save()){
							if($type == 'add'){
								$message = 'Thêm phụ đề (' . $filmSub->id . ') thành công';
							}
							if($type == 'edit'){
								$message = 'Chỉnh sửa phụ đề (' . $filmSub->id . ') thành công';
							}
							// \Functions::saveLogAdmin($login_user->id, $message);
						}
					}
				}
				
				// return \Redirect::route('filmEp.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				\DB::rollback();
				echo $e->getMessage();die;
			}
			\DB::commit();
			if($type == 'add'){
				$message = 'Thêm tập phim và phụ đề thành công';
			}
			if($type == 'edit'){
				$message = 'Chỉnh sửa tập phim và phụ đề thành công';
			}
			return \Response::json(array(
				'success' => true,
			), 200);
		}

		return View::make('admin::filmEp.form', array('film' => @$film, 'filmEpData' => $filmEpField, 'filmQuality' => $filmQuality, 'sectionFilm' => $sectionFilm, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}