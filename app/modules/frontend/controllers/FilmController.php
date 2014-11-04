<?php
namespace App\Modules\Frontend\Controllers;

use View,
		App\Modules\Frontend\Models\Film as FilmModel;

class FilmController extends \FrontendController{
	
	public function detail($id){
		if($id != ''){
			$filmModel = new FilmModel;
			$film =  $filmModel->getDetail($id);
			return View::make('frontend::film.detail',array(
				'film' => $film
			))->with('title', 'Detail');
		}
	}
	
	public function getSubtitleFilm(){
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