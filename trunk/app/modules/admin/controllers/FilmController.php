<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Film
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\SectionFilm as SectionFilmModel,
	App\Modules\Admin\Models\CatalogueFilm as CatalogueFilmModel,
	App\Modules\Admin\Models\Film as FilmModel,
	App\Modules\Admin\Models\FilmEp as FilmEpModel,
	App\Modules\Admin\Models\FilmSubtitle as FilmSubtitleModel,
	App\Modules\Admin\Models\Position as PositionModel,
	App\Modules\Admin\Models\Video as VideoModel,
	App\Modules\Admin\Models\Tags as TagsModel,
	App\Modules\Admin\Models\Ribbon as RibbonModel;

class FilmController extends \BaseController{

	public function getShowMovie(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmModel;
			$response = $model->getData($params,1);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::film.listMovie');
	}

	public function getShowDrama(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new FilmModel;
			$response = $model->getData($params,2);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::film.listDrama');
	}

	public function modify($id){
		$filmField = '';
		$film = '';
		$method = \Functions::getMethodPrevious('film');
		$arrMethod = array('Movie','Drama');
		if(in_array($method, $arrMethod)){
			\Session::put('previosMethod', $method);
		}

		$dataSectionFilm = SectionFilmModel::all()->toArray();
		$sectionFilm[] = 'Choose Section of Film';
		
		foreach($dataSectionFilm as $item){
			$sectionFilm[$item['id']] = $item['name'];
		}
		unset($dataSectionFilm);

		$dataCatalogueFilm = CatalogueFilmModel::all()->toArray();
		$catalogueFilm[] = 'Choose Catalogue of Film';
		
		foreach($dataCatalogueFilm as $item){
			$catalogueFilm[$item['id']] = $item['name'];
		}
		
		$dataRibbon = RibbonModel::all()->toArray();
		$ribbon[0] = 'None';
		
		foreach($dataRibbon as $item){
			$ribbon[$item['id']] = $item['name'];
		}
		unset($dataRibbon);

		if($id != ''){
			$filmField = FilmModel::findOrFail($id);
			$film = FilmModel::findOrFail($id);
			$dataVideo = VideoModel::where('film_id', '=', $id)
											->where('cata_id', '=', 1)->first();
			$filmField['trailer'] = $dataVideo['url'];
		}
		
		$filmEp = new FilmEpModel;
		$filmSubtitle = new FilmSubtitleModel;
		$video = new VideoModel;
		$tags = new TagsModel;
		$position = new PositionModel;

		if(\Request::isMethod('post')){
			if($filmField == ''){
				$filmField = new FilmModel;
			}

			if($film == ''){
				$film = new FilmModel;
			}

			$dataSource = \Input::get();
			
			$rules = array(
				'en_title' => 'required',
				'cata_id' => 'required'
			);

			$validator = \Validator::make($dataSource, $rules);

			unset($dataSource['ok'], $dataSource['_token']);

			$filmInput = array('id','sec_id','cata_id','en_title','vn_title','release_date','imdb_rating','imdb_vote','imdb_link','poster','banner','en_description','vn_description','idIMDB','status','depute','coming','ribbon_id');
			$posInput = array('producer','director','cast');
			$videoInput = array('trailer');
			$tagsInput = array('tags');

			$flagPos = 0;
			$flagTags = 0;
			$dataVideo = array();

			foreach($dataSource as $field => $value){
				if($field == 'id'){
					if($value == ''){
						continue;
					}
				}
				$filmField->{$field} = $value;
				if(in_array($field, $filmInput)){
					if($field == 'cata_id'){
						$value = implode(',',$value);	
					}elseif($field == 'imdb_vote'){
						$value = str_replace(',', '', $value);
					}elseif($field == 'id'){
						if($value == ''){
							continue;
						}
					}elseif($field == 'en_title'){
						$film->en_title_url = \Functions::strToUrl($value);
						$film->en_search = \Functions::strToUrl($value, ' ');
					}elseif($field == 'vn_title'){
						if($value){
							$film->vn_title_url = \Functions::strToUrl($value);
							$film->vn_search = \Functions::strToUrl($value, ' ');
						}
					}
					$film->{$field} = $value;
				}elseif(in_array($field, $posInput)){
					if($value){
						$dataInsert['position'][$field.'_id'] = $value;
						$flagPos = 1;
					}else{
						$fieldColumn = $field.'_id';
						$film->$fieldColumn = '';
					}
				}elseif(in_array($field, $videoInput)){
					if($value){
						if($field == 'trailer'){
							$field = 'url';
						}
						$dataVideo[$field] = $value;
					}
				}elseif(in_array($field, $tagsInput)){
					if($value){
						$dataInsert['tags'][] = $value;
						$flagTags = 1;
					}else{
						$film->tags_id = '';
					}
				}
			}

			
			if($validator->fails()){
				return View::make('admin::film.form', array('method' => \Session::get('previosMethod'), 'filmData' => $filmField, 'sectionFilm' => $sectionFilm, 'catalogueFilm' => $catalogueFilm, 'ribbon' => $ribbon, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($flagPos == 1){
					foreach($dataInsert['position'] as $keyPos => $valuePos){
						if($keyPos == 'producer_id'){
							$cataloguePos = 1;
						}elseif($keyPos == 'director_id'){
							$cataloguePos = 2;
						}else{
							$cataloguePos = 3;
						}

						if($valuePos){
							$dataValuePos = explode(',',$valuePos);
							$dataIdPos[$keyPos] = array();
							if(count($dataValuePos) > 1){
								foreach($dataValuePos as $valuePos2){
									$valuePos2 = trim($valuePos2);
									$check = PositionModel::where('fullname', 'LIKE', $valuePos2)
															->where('cata_id', '=', $cataloguePos)->get();

									if($check->count() == 0){
										$dataIdPos[$keyPos][] = \DB::table('position')->insertGetId(
											array(
												'fullname' => $valuePos2, 
												'cata_id' => $cataloguePos,
												'updated_at' => date('Y-m-d H:i:s'),
												'updated_by' => \Auth::admin()->user()->id
											)
										);
									}else{
										foreach($check as $item){
											$dataIdPos[$keyPos][] = $item->id;
										}
									}
								}
							}else{
								$valuePos = trim($valuePos);
								$check = PositionModel::where('fullname', 'LIKE', $valuePos)
														->where('cata_id', '=', $cataloguePos)->get();

								if($check->count() == 0){
									$dataIdPos[$keyPos][] = \DB::table('position')->insertGetId(
										array(
											'fullname' => $valuePos, 
											'cata_id' => $cataloguePos,
											'updated_at' => date('Y-m-d H:i:s'),
											'updated_by' => \Auth::admin()->user()->id
										)
									);
								}else{
									foreach($check as $item){
										$dataIdPos[$keyPos][] = $item->id;
									}
								}
							}
							foreach($dataIdPos as $keyId => $idPos){
									$film->{$keyId} = implode(',',$idPos);
							}
						}
					}
				}
				
				if($flagTags == 1){
					foreach($dataInsert['tags'] as $valueTags){
						$dataValueTags = explode(',',$valueTags);
						$dataIdTags = array();
						if(count($dataValueTags) > 1){
							foreach($dataValueTags as $valueTags2){
								$valueTags2 = trim($valueTags2);
								$check = TagsModel::where('name', 'LIKE', $valueTags2)->get();

								if($check->count() == 0){
									$dataIdTags[] = \DB::table('tags')->insertGetId(
										array(
											'name' => $valueTags2, 
											'url' => \Functions::strToUrl($valueTags2),
											'created_by' => \Auth::admin()->user()->id,
											'updated_by' => \Auth::admin()->user()->id
										)
									);
								}else{
									foreach($check as $item){
										$dataIdTags[] = $item->id;
									}
								}
							}
						}else{
							$valueTags = trim($valueTags);
							$check = TagsModel::where('name', 'LIKE', $valueTags)->get();

							if($check->count() == 0){
								$dataIdTags[] = \DB::table('tags')->insertGetId(
									array(
										'name' => $valueTags, 
										'url' => \Functions::strToUrl($valueTags),
										'created_by' => \Auth::admin()->user()->id,
										'updated_by' => \Auth::admin()->user()->id
									)
								);
							}else{
								foreach($check as $item){
									$dataIdTags[] = $item->id;
								}
							}
						}
						$film->tags_id = implode(',',$dataIdTags);
					}
				}
				
				if($id == ''){
					$film->created_by = \Auth::admin()->user()->id;
					$film->created_at = date('Y-m-d H:i:s');
					$film->updated_by = \Auth::admin()->user()->id;
				}else{
					$film->updated_by = \Auth::admin()->user()->id;
					$film->updated_at = date('Y-m-d H:i:s');
				}
				$film->save();
				$idFilm = $film->id;
				if($id != ''){
					\Functions::saveLogAdmin(4, $id);
				}else{
					\Functions::saveLogAdmin(3, $idFilm);
				}
				
				\DB::table('film_view')->insert(array(
					'film_id' => $idFilm
				));
				
				if(!empty($dataVideo)){
					$check = VideoModel::where('film_id', '=', $idFilm)
											->where('cata_id', '=', 1)->get()->count();
					if($check == 0){
						$dataVideo['film_id'] = $idFilm;
						$dataVideo['cata_id'] = 1;
						$dataVideo['created_at'] = date('Y-m-d H:i:s');
						$dataVideo['created_by'] = \Auth::admin()->user()->id;
						\DB::table('video')->insert($dataVideo);
					}else{
						$dataVideo['updated_at'] = date('Y-m-d H:i:s');
						$dataVideo['updated_by'] = \Auth::admin()->user()->id;
						\DB::table('video')
				            ->where('film_id', $idFilm)
				            ->update($dataVideo);
					}
				}

				return \Redirect::route('film.show'.\Session::get('previosMethod'))->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::film.form', array('method' => \Session::get('previosMethod'), 'filmData' => $filmField, 'sectionFilm' => $sectionFilm, 'catalogueFilm' => $catalogueFilm, 'ribbon' => $ribbon, 'tags' => $tags, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}

	public function postSearchDataMovie(){
		if(\Request::ajax()){
			$params = \Input::get();
			$results = \MyImdb::searchDataMovieByTitle($params['en_title']);
			$data = array();
			foreach ($results as $res) {
				$data[] = array(
					'id' => $res->imdbid(),
					'title' => $res->title(),
					'year' => $res->year(),
					'catalogue' => $res->addon_info
				);
			}
			return json_encode($data);
		}
	}
	
	public function postGetDetailFilm(){
		if(\Request::ajax()){
			$params = \Input::get();
			$movie = \MyImdb::getDetailMovie($params['id']);
			$data = array(
				'title' => $movie->title(),
				'year' => $movie->year(),
				'photo' => $movie->photo_localurl(),
				'time' => $movie->runtime(),
				'rating' => $movie->rating(),
				'votes' => $movie->votes(),
				'director' => $movie->director(),
				'writing' => $movie->writing(),
				'producer' => $movie->producer(),
				'composer' => $movie->composer(),
				'cast' => $movie->cast(),
				'locations' => $movie->locations(),
				'soundtrack' => $movie->soundtrack(),
				'imdb_link' => $movie->main_url(),
				'imdb_id' => $movie->imdbid()
			);		
			return json_encode($data);
		}
	}
	
	public function postGetDataFilmBySection(){
		if(\Request::ajax()){
			$params = \Input::get();
			$data = FilmModel::where('sec_id', $params['id'])->get(array('id', 'en_title', 'vn_title'))->toArray();
			//$data = FilmModel::where('sec_id', $params['id'])->select('id',\DB::raw('IF(en_title != "",en_title,vn_title) AS text'))->get()->toArray();
			return json_encode($data);
		}
	}
	
	public function postExport(){
		$params = \Input::get();
		$sectionFilm = $params['sectionFilm'];
		unset($params['sectionFilm']);
		$film = new FilmModel;
		$film = $film->getExportData($params, $sectionFilm);
		\Functions::export($film);
		die;
	}

	public function postUpdateFilm(){
		if(\Request::ajax()){
			$params = \Input::get();
			$data = FilmModel::where('id', '=', $params['id'])->update(array($params['type'] => $params['value']));
			//$data = FilmModel::where('sec_id', $params['id'])->select('id',\DB::raw('IF(en_title != "",en_title,vn_title) AS text'))->get()->toArray();
			return \Response::json(array('success' => true, 'message' => 'Change Successfully!'), 200);
		}
	}
	
	public function postWatchFilm(){
		if(\Request::ajax()){
			$data = \Input::get();
			$prefix = \DB::getTablePrefix();
			$dataVideo = \DB::table('film as '.$prefix.'a')
					->select('a.id', 'a.en_title','a.vn_title','a.banner','b.ep_link','c.subtitle_url','d.name')
					->leftJoin('film_ep as '.$prefix.'b','a.id', '=', 'b.film_id')
					->leftJoin('film_subtitle as '.$prefix.'c','b.id', '=', 'c.ep_id')
					->leftJoin('language as '.$prefix.'d','c.lang_id', '=', 'd.id')
					->where('a.id','=',$data['id'])
					->get();
			$respone = array();
			$countData = count($dataVideo);
			if($countData > 0){
				$oldId = 0;
				foreach($dataVideo as $item){
					if($oldId != $item->id){
						$title = $item->en_title;
						if($item->en_title == ''){
							$title = vn_title;
						}
						$respone['title'] = $title;
						if($item->ep_link != ''){
							$respone['file'] = $item->ep_link;
						}
						if($item->banner != ''){
							$respone['banner'] = $item->banner;
						}
						if($item->subtitle_url != ''){
							$respone['subtitle'][0]['subtitle_file'] = $item->subtitle_url;
							if($item->name != ''){
								$respone['subtitle'][0]['language'] = $item->name;
								$respone['default'][0]['default'] = true;
							}
						}
						
					}else{
						if($item->subtitle_url != ''){
							$language = '';
							$default = false;
							if($item->name != ''){
								$language = $item->name;
								if($language == 'Vietnamese'){
									$default = true;
								}
							}
							$respone['subtitle'][] = array(
								'subtitle_file' => $item->subtitle_url,
								'language' => $language,
								'default' => $default
							);
						}
					}
					$oldId = $item->id;
				}
			}
			return json_encode($respone);
		}
	}

}