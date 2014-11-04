<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-20
 * Description: Class Data
 */
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Models\Position as PositionModel,
	App\Modules\Admin\Models\CatalogueFilm as CatalogueFilmModel,
	App\Modules\Admin\Models\FilmQuality as FilmQualityModel,
	App\Modules\Admin\Models\Film as FilmModel,
	App\Modules\Admin\Models\FilmEp as FilmEpModel,
	App\Modules\Admin\Models\FilmSubtitle as FilmSubtitleModel,
	App\Modules\Admin\Models\Video as VideoModel;

class DataController extends \BaseController{
	
	public function __construct() {
		parent::__construct();
	}
	
	public function postUpdateDataFilm(){
		if(\Request::ajax()){
			ini_set('max_execution_time', 0);
			$dataFilmTemp = \DB::table('film_temp')->get();
			$dataTrailer = $dataEp = $dataSub = $dataFilm = array();
			foreach($dataFilmTemp as $dT){
				$checkFilm = FilmModel::where('old_id', '=', $dT->old_id)->get();
				$sec_id = $en_title = $en_search = $en_title_url = $vn_title = $vn_search = $vn_title_url = $idDirector = $idCast = $quality_id = "";
				if(count($checkFilm) == 0){
					
					if($dT->en_title != ""){
						$en_title = ucwords(strtolower($dT->en_title));
						$en_search = \Functions::strToUrl($en_title, ' ');
						$en_title_url = \Functions::strToUrl($en_search);
					}
					if($dT->vn_title != ""){
//						$vn_title = ucwords(strtolower($dT->vn_title));
						$vn_title = $dT->vn_title;
						$vn_search = \Functions::strToUrl($vn_title, ' ');
						$vn_title_url = \Functions::strToUrl($vn_search);
					}

					if($dT->director != ""){
						$idDirector = $this->getIdPosition($dT->director,2);
					}
					if($dT->cast != ""){
						$idCast = $this->getIdPosition($dT->cast,3);
					}
					if($dT->cata_name != ""){
						$idCata = $this->getIdCatalogue($dT->cata_name);
					}
					if($dT->sec_id != ""){
						$sec_id = trim($dT->sec_id);
					}

					if($dT->quality_name != ""){
						$quality_id = FilmQualityModel::where('code', '=', $dT->quality_name)->first();
						$quality_id = $quality_id['id'];
					}
				
					$dataFilm = array(
						'old_id' => $dT->old_id,
						'sec_id' => $sec_id,
						'en_title' => $en_title,
						'en_search' => $en_search,
						'en_title_url' => $en_title_url,
						'vn_title' => $vn_title,
						'vn_search' => $vn_search,
						'vn_title_url' => $vn_title_url,
						'director_id' => $idDirector,
						'cast_id' => $idCast,
						'poster' => $dT->poster,
						'banner' => $dT->banner,
						'cata_id' => $idCata,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
						'created_by' => \Auth::admin()->user()->id,
						'updated_by' => \Auth::admin()->user()->id
					);
					$idFilm = \DB::table('film')->insertGetId($dataFilm);

					if($dT->trailer != ""){
						$this->insertTrailer($dT->trailer, $idFilm);
					}

					if($dT->ep_url != ""){
						$this->insertEpAndSub($dT->ep, $dT->ep_url, $dT->lang_id, $dT->subtitle_url, $quality_id, $idFilm, $dT->view);
					}
				}else{
					if($dT->sec_id != ""){
						$sec_id = trim($dT->sec_id);
					}
					foreach($checkFilm as $vC){
						if($dT->trailer != ""){
							$this->insertTrailer($dT->trailer, $vC->id);
						}

						if($dT->ep_url != ""){
							$this->insertEpAndSub($sec_id, $dT->ep, $dT->ep_url, $dT->lang_id, $dT->subtitle_url, $quality_id, $vC->id, $dT->view);
						}
					}
				}
			}
		}
	}
	
	public function insertTrailer($trailer, $filmId){
		if(filter_var($trailer, FILTER_VALIDATE_URL)){
			$checkTrailer = VideoModel::where('film_id', '=', $filmId)
							->where('cata_id', '=', 1)->count();
			if($checkTrailer == 0){
				\DB::table('video')->insert(array(
					'url' => $trailer, 
					'film_id' => $filmId,
					'cata_id' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'created_by' => \Auth::admin()->user()->id,
					'updated_by' => \Auth::admin()->user()->id
				));
			}
		}
	}
	
	public function insertView($filmId, $epId, $total){
		\DB::table('film_view')->insert(array(
			'film_id' => $filmId,
			'ep_id' => $epId,
			'total' => $total,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		));
	}
	
	public function insertEpAndSub($ep, $epUrl, $langId, $subUrl, $qualityId, $filmId, $view){
		if(filter_var($epUrl, FILTER_VALIDATE_URL)){
			$checkEp = FilmEpModel::where('film_id', '=', $filmId)
							->where('ep', '=', $ep)
							->where('quality_id', '=', $qualityId)
							->get();
			if(count($checkEp) == 0){
				$idEp = \DB::table('film_ep')->insertGetId(array(
					'film_id' => $filmId,
					'ep' => $ep,
					'ep_link' => $epUrl,
					'quality_id' => $qualityId,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					'created_by' => \Auth::admin()->user()->id,
					'updated_by' => \Auth::admin()->user()->id
				));
				$this->insertView($filmId, $idEp, $view);
				if($subUrl != ""){
					$this->queryInsertSubtitle($idEp, $langId, $subUrl);
				}
			}else{
				if($subUrl != ""){
					foreach($checkEp as $vC){
						$this->queryInsertSubtitle($vC->id, $langId, $subUrl);
					}
				}
			}
		}
	}
	
	public function queryInsertSubtitle($epId, $langId, $subUrl){
		$checkSub = FilmSubtitleModel::where('ep_id', '=', $epId)
				->where('lang_id', '=', $langId)
				->count();
		if($checkSub == 0){
			\DB::table('film_subtitle')->insert(array(
				'ep_id' => $epId,
				'subtitle_url' => $subUrl,
				'lang_id' => $langId,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
				'created_by' => \Auth::admin()->user()->id,
				'updated_by' => \Auth::admin()->user()->id
			));
		}
	}
	
	public function getIdPosition($value, $cataId){
		$arrValue = explode(',',$value);
		$arrStrReplace = array("(", ")", "\"", "...", "…..", "…", "..", "screenplay", "N/A", "Ung Chính Thái Thiếu Phân", "Beyond The Realm Of Conscience 2009", "Chiến Tranh Giữa Các Vì Sao 6: Sự Trở Lại Của Jedi", PHP_EOL, "&nbsp;", "Đang cập nhật");
		$arrPregReplace = array("|", "vai", "Kịch bản", "character", "1 more");
		$arrBad = array(' and ','và',' with ', '&amp;');
		$dataId = array();
		$badData = array();
		if(count($arrValue) > 1){
			foreach($arrValue as $item){
				$item = preg_replace('/\s+/', ' ', $item);
				//$item = preg_replace($arrPregReplace, '', $item);
				foreach($arrPregReplace as $pR){
					if(strpos($item, $pR)){
						$item = substr($item, 0, strpos($item, $pR));
					}
				}
				$item = str_replace($arrStrReplace,'',$item);
				$item = trim($item);
				if($item != ""){
					if(\Functions::strposArray($item,array('and','và','with')) !== false){
						$badData[] = $item;
					}else{
						$check = PositionModel::where('fullname_url', '=', \Functions::strToUrl($item))
										->where('cata_id', '=', $cataId)->get();

						if(count($check) == 0){
							$dataId[] = \DB::table('position')->insertGetId(
								array(
									'fullname' => $item, 
									'cata_id' => $cataId, 
									'fullname_url' => \Functions::strToUrl($item),
									'updated_at' => date('Y-m-d H:i:s'),
									'updated_by' => \Auth::admin()->user()->id
								)
							);
						}else{
							foreach($check as $vC){
								$dataId[] = $vC->id;
							}
						}
					}
				}
			}
		}else{
			$value = preg_replace('/\s+/', ' ', $value);
			//$value = preg_replace($arrPregReplace, '', $value);
			foreach($arrPregReplace as $pR){
				if(strpos($value, $pR)){
					$value = substr($value, 0, strpos($value, $pR));
				}
			}
			$value = str_replace($arrStrReplace,'',$value);
			$value = trim($value);
			if($value != ""){
				if(\Functions::strposArray($value,$arrBad) !== false){
					$badData[] = $value;
				}else{
					$check = PositionModel::where('fullname_url', '=', \Functions::strToUrl($value))
											->where('cata_id', '=', $cataId)->get();

					if(count($check) == 0){
						$dataId[] = \DB::table('position')->insertGetId(
							array(
								'fullname' => $value, 
								'cata_id' => $cataId, 
								'fullname_url' => \Functions::strToUrl($value),
								'updated_at' => date('Y-m-d H:i:s'),
								'updated_by' => \Auth::admin()->user()->id
							)
						);
					}else{
						foreach($check as $vC){
							$dataId[] = $vC->id;
						}
					}
				}
			}
		}
		if($badData){
			foreach($badData as $bD){
				$arrBD = \Functions::explodeArray($arrBad,$bD);
				foreach($arrBD as $iADB){
					if($iADB != ""){
						$check = PositionModel::where('fullname_url', '=', \Functions::strToUrl($iADB))
											->where('cata_id', '=', $cataId)->get();

						if(count($check) == 0){
							$dataId[] = \DB::table('position')->insertGetId(
								array(
									'fullname' => $iADB, 
									'cata_id' => $cataId, 
									'fullname_url' => \Functions::strToUrl($iADB),
									'updated_at' => date('Y-m-d H:i:s'),
									'updated_by' => \Auth::admin()->user()->id
								)
							);
						}else{
							foreach($check as $vC){
								$dataId[] = $vC->id;
							}
						}
					}
				}
			}
		}
		return implode(',',$dataId);
	}
	
	public function getIdCatalogue($value){
		$arrValue = explode(',',$value);
		$dataId = array();
		if(count($arrValue) > 1){
			foreach($arrValue as $item){
				$item = trim($item);
				$check = CatalogueFilmModel::where('name', 'LIKE', $item)->get();

				if(count($check) != 0){
					foreach($check as $vC){
						$dataId[] = $vC->id;
					}
				}
			}
		}else{
			$value = trim($value);
			$check = CatalogueFilmModel::where('name', 'LIKE', $value)->get();

			if(count($check) != 0){
				foreach($check as $vC){
					$dataId[] = $vC->id;
				}
			}
		}
		return implode(',',$dataId);
	}

	public function postUpdatePosition(){
		if(\Request::ajax()){
			ini_set('max_execution_time', 0);
			$dataPosition = \DB::table('position')->select('id', 'fullname', 'idIMDB')->where('check','=',0)->get();
			$dataUpdate = array();
			foreach($dataPosition as $dP){
				$idPos = 0;
				if($dP->idIMDB == ''){
					$results = \MyImdb::searchDataPositionByName($dP->fullname);
					if($results){
						foreach ($results as $res) {
							if($res->name() == $dP->fullname){
								$idPos = $res->imdbid();
								break;
							}
						}	
					}
				}else{
					$idPos = $dP->idIMDB;
				}
				if($idPos != 0){
					$dataDetailPosition = \MyImdb::getDetailPosition($idPos);
					$dataUpdate['idIMDB'] = $idPos;
					
					if($dataDetailPosition->photo_localurl() != FALSE){
						$dataUpdate['avatar'] = $dataDetailPosition->photo_localurl();
					}
					
					$birthday = $dataDetailPosition->born();
					if (!empty($birthday)) {
						$dataUpdate['country'] = $birthday["place"];
						$dataUpdate['date_of_birth'] = str_replace('&nbsp;','',$birthday["day"])."/".str_replace('&nbsp;','',$birthday["month"])."/".str_replace('&nbsp;','',$birthday["year"]);
						$dataUpdate['date_of_birth'] = \Functions::changeDate($dataUpdate['date_of_birth']);
					}

					$death = $dataDetailPosition->died();
					if (!empty($death)) {
						$dataUpdate['date_of_death'] = str_replace('&nbsp;','',$death["day"])."/".str_replace('&nbsp;','',$death["month"])."/".str_replace('&nbsp;','',$death["year"]);
						$dataUpdate['date_of_death'] = \Functions::changeDate($dataUpdate['date_of_death']);
					}

					$nicks = $dataDetailPosition->nickname();
					if (!empty($nicks)) {
						$dataUpdate['nickname'] = str_replace('<br>',',',implode(',',$nicks));	
					}

					$bh = $dataDetailPosition->height();
					if (!empty($bh)) {
						$dataUpdate['body_height'] = $bh["metric"];
					}

					$bio = $dataDetailPosition->bio();
					if (!empty($bio)) {
						if (count($bio)<2) $idx = 0; else $idx = 1;
						$dataBio = preg_replace('/http\:\/\/'.str_replace(".","\.",$dataDetailPosition->imdbsite).'\/name\/nm(\d{7})\//','?mid=\\1',$bio[$idx]["desc"])."<br />(Written by: ".$bio[$idx]['author']['name'].")";
						$dataUpdate['en_description'] = $dataBio;
					}

					$dataUpdate['check'] = 1;
					$dataUpdate['updated_at'] = date('Y-m-d H:i:s');
					$dataUpdate['updated_by'] = \Auth::admin()->user()->id;

					\DB::table('position')
			            ->where('id', $dP->id)
			            ->update($dataUpdate);

			        unset($dataUpdate);
				}
			}
		}
	}
	
	public function getDataUserStatistics(){
		if(\Request::ajax()){
			/**
			* Set the callback variable to what jQuery sends over
			*/
			$callback = (string)$_GET['callback'];
			if (!$callback) $callback = 'callback';

			/**
			* The $filename parameter determines what file to load from local source
			*/
			$filename = '/public/data/'.$_GET['filename'];
	//		if (preg_match('/^[a-zA-Z\-\.]+\.json$/', $filename)) {
	//			$json = file_get_contents($filename);
	//		}
	//		if (preg_match('/^[a-zA-Z\-\.]+\.csv$/', $filename)) {
				$csv = str_replace('"', '\"', file_get_contents($filename));
				$csv = preg_replace( "/[\r\n]+/", "\\n", $csv);
				$json = '"' . $csv . '"';
	//		}

			/**
			* The $url parameter loads data from external sources
			*/
	//		@$url = $_GET['url'];
	//		if ($url) {
	//			if (preg_match('/^(http|https):\/\/[\w\W]*\.xml$/', $url)) {
	//				$xml = simplexml_load_file($url);
	//				$json = json_encode($xml);
	//			} else if (preg_match('/^(http|https):\/\/[\/\w \.-]*\.csv$/', $url)) {
	//				$csv = str_getcsv(file_get_contents($url));
	//				$json = json_encode($xml);

				// Assume JSON
	//			} else if (preg_match('/^(http|https):\/\/[\/\w \.-]*$/', $url)) {
	//				$json = file_get_contents($url);
	//			}
	//		}

			// Send the output
			header('Content-Type: text/javascript');
			echo "$callback($json);";
		}
	}


	public function postUpdateUserStatistics(){
		if(\Request::ajax()){
			
		}
	}
	
	public function postClearAllCache(){
		if(\Request::ajax()){
			\Cache::flush();
		}
	}
}