<?php
class Films {
	
	public static function getInfoFooter($type, $limit){
		$responce = array();
		if($type == 'movie'){
			if(Cache::has('blockFooterNewMovie')){
				return Cache::get('blockFooterNewMovie');
			}else{
				$data = DB::table('film')
					->select('en_title','en_title_url')
					->where('sec_id', 1)
					->where('status', 1)
					->orderBy('created_at', 'desc')
					->take($limit)
					->get();
				if(!empty($data)){
					foreach($data as $item){
						$responce[] = array(
							'title' => $item->en_title,
							'url' => $item->en_title_url
						);
					}
				}
				Cache::put('blockFooterNewMovie', $responce, 360);
			}
		}elseif($type == 'drama'){
			if(Cache::has('blockFooterNewDrama')){
				return Cache::get('blockFooterNewDrama');
			}else{
				$data = DB::table('film')
					->select('en_title','en_title_url')
					->where('sec_id', 2)
					->where('status', 1)
					->orderBy('created_at', 'desc')
					->take($limit)
					->get();
				if(!empty($data)){
					foreach($data as $item){
						$responce[] = array(
							'title' => $item->en_title,
							'url' => $item->en_title_url
						);
					}
				}
				Cache::put('blockFooterNewDrama', $responce, 360);
			}
		}elseif($type == 'cast'){
			if(Cache::has('blockFooterCast')){
				return Cache::get('blockFooterCast');
			}else{
				$data = DB::table('position')
					->select('fullname','fullname_url')
					->where('cata_id', 3)
					->orderBy('view', 'desc')
					->take($limit)
					->get();
				if(!empty($data)){
					foreach($data as $item){
						$responce[] = array(
							'title' => $item->fullname,
							'url' => $item->fullname_url
						);
					}
				}
				Cache::put('blockFooterCast', $responce, 360);
			}
		}
		return $responce;
	}
	
	public static function getFilmDepute(){
		$responce = array();
		if(Cache::has('blockDepute')){
			return Cache::get('blockDepute');
		}else{
			$data = DB::table('film')
				->select('en_title','en_title_url','banner')
				->where('depute', 1)
				->where('status', 1)
				->orderBy('created_at', 'desc')
				->get();
			if(!empty($data)){
				foreach($data as $item){
					$responce[] = array(
						'title' => $item->en_title,
						'url' => $item->en_title_url,
						'banner' => $item->banner
					);
				}
			}
			Cache::put('blockDepute', $responce, 360);
		}
		return $responce;
	}
	
	public static function getFilm($type = '', $sec_id = 0, $cata_id = 0, $limit = 0){
		$responce = array();
		$key = 'blockFilm_'.$type.'_'.$sec_id.'_'.$cata_id.'_'.$limit;
		// Cache::forget($key);
		if(Cache::has($key)){
			return Cache::get($key);
		}else{
			$pf = \DB::getTablePrefix();
			$dataFieldSelect = array(
				'f.id',
				'f.en_title',
				'f.en_title_url',
				'f.vn_title',
				'f.vn_title_url',
				'f.release_date',
				'f.poster',
				'f.imdb_rating',
				'vi.url',
				'f.ribbon_id',
				'r.name'
			);
			$fieldSelect = \DB::raw($pf.implode(','.$pf,$dataFieldSelect));
			if($type == 'filter'){
				$limit = 10;
				$queryNewMovie = DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('"" as view,"newMovie" as mix'))
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->where('f.status', 1)
					->where('f.sec_id', 1)
					->orderBy('f.created_at', 'desc')
					->take($limit)
					->get();
				
				$queryNewDrama = DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('"" as view,"newDrama" as mix'))
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->where('f.status', 1)
					->where('f.sec_id', 2)
					->orderBy('f.created_at', 'desc')
					->take($limit)
					->get();
				
				$queryMostMovie = DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('SUM('.$pf.'v.total) as view,"mostMovie" as mix'))
					->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->where('f.status', 1)
					->where('f.sec_id', 1)
					->orderBy(\DB::raw('SUM('.$pf.'v.total)'), 'desc')
					->groupBy('f.id')
					->take($limit)
					->get();
				
				$queryMostDrama = DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('SUM('.$pf.'v.total) as view,"mostDrama" as mix'))
					->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->where('f.status', 1)
					->where('f.sec_id', 2)
					->orderBy(\DB::raw('SUM('.$pf.'v.total)'), 'desc')
					->groupBy('f.id')
					->take($limit)
					->get();
				$data = (object)array_merge((array)$queryNewMovie, (array)$queryNewDrama, (array)$queryMostMovie, (array)$queryMostDrama);
			}else{
				$query = DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('SUM('.$pf.'v.total) as view,"" as mix'))
					->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->where('f.status', 1)
					->orderBy('f.created_at', 'desc')
					->groupBy('v.film_id');
				if($type == 'soon'){
					$query->where('coming', 1);
				}
				if($sec_id != 0){
					$query->where('sec_id', $sec_id);
				}
				if($cata_id != 0){
					$query->where('cata_id', $cata_id);
				}
				if($limit != 0){
					$query->take($limit);
				}
			}
			if(empty($data)){
				$data = $query->get();
			}
		
			if(!empty($data)){
//				echo '<pre>';
//				print_r($data);
//				echo '</pre>';
//				die();
				$i = 0;
				$oldId = 0;
				foreach($data as $item){
					if($oldId != $item->id){
						$urlVideo = $title = '';
						if($item->url != ''){
							$urlVideo = Functions::getIdYoutubeFromUrl($item->url);
						}
						$title = $item->en_title;
						$url = $item->en_title_url;
						if($item->vn_title != ''){
							if($item->en_title != ''){
								$title = $title.' - '.$item->vn_title;
							}else{
								$title = $item->vn_title;
							}
							$url = $item->vn_title_url;
						}

						$responce[$item->id] = array(
							'id' => $item->id,
							'title' => $title,
							'url' => $url,
							'releaseDate' => $item->release_date,
							'poster' => $item->poster,
							'imdbPoint' => $item->imdb_rating,
							'view' => $item->view,
							'idYoutube' => $urlVideo,
							'ribbon' => $item->ribbon_id,
							'ribbonDescription' => $item->name,
							'mix' => $item->mix
						);
					}else{
						$responce[$item->id]['mix'] = $responce[$item->id]['mix'].' '.$item->mix;
					}
					$oldId = $item->id;
					$i++;
				}
			}
			Cache::put($key, $responce, 360);
		}
		return $responce;
	}
	
	public static function getFilmOther($currentId, $cata_id, $limit = 0){
		$responce = array();
		$key = 'blockFilmOther_'.$cata_id.'_'.$limit;
		// Cache::forget($key);
		if(Cache::has($key)){
			return Cache::get($key);
		}else{
			$pf = \DB::getTablePrefix();
			$query = DB::table('film as '.$pf.'f')
				->select('f.id','f.en_title','f.en_title_url','f.vn_title','f.vn_title_url','f.release_date','f.poster','f.imdb_rating',\DB::raw('SUM('.$pf.'v.total) as view'),'vi.url','f.ribbon_id','r.name')
				->leftJoin('catalogue_film as '.$pf.'c', 'c.id','=',\DB::raw($pf.'c.id AND FIND_IN_SET('.$pf.'c.id, '.$pf.'f.cata_id)'))
				->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
				->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
				->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
				->where('f.status', 1)
				->whereNotIn('f.id', array($currentId))
				->orderBy(DB::raw('RAND()'))
				->groupBy('v.film_id');
			if($cata_id != 0){
				$query->whereIn('c.id', explode(',',$cata_id));
			}
			if($limit != 0){
				$query->take($limit);
			}
			$data = $query->get();
			if(!empty($data)){
				foreach($data as $item){
					$urlVideo = $title = '';
					if($item->url != ''){
						$urlVideo = Functions::getIdYoutubeFromUrl($item->url);
					}
					$title = $item->en_title;
					$url = $item->en_title_url;
					if($item->vn_title != ''){
						if($item->en_title != ''){
							$title = $title.' - '.$item->vn_title;
						}else{
							$title = $item->vn_title;
						}
						$url = $item->vn_title_url;
					}
					$responce[] = array(
						'id' => $item->id,
						'title' => $title,
						'url' => $url,
						'releaseDate' => $item->release_date,
						'poster' => $item->poster,
						'imdbPoint' => $item->imdb_rating,
						'view' => $item->view,
						'idYoutube' => $urlVideo,
						'ribbon' => $item->ribbon_id,
						'ribbonDescription' => $item->name
					);
				}
			}
			Cache::put($key, $responce, 360);
		}
		return $responce;
	}

	public static function getFilmPosition($pos_id, $limit = 0){
		$responce = array();
		$key = 'blockFilmPosition_'.$pos_id.'_'.$limit;
		// Cache::forget($key);
		if(Cache::has($key)){
			return Cache::get($key);
		}else{
			$pf = \DB::getTablePrefix();
			$query = DB::table('film as '.$pf.'f')
				->select('f.id','f.en_title','f.en_title_url','f.vn_title','f.vn_title_url','f.release_date','f.poster','f.imdb_rating',\DB::raw('SUM('.$pf.'v.total) as view'),'vi.url','f.ribbon_id','r.name')
				->leftJoin('position as '.$pf.'p', 'p.id','=',\DB::raw($pf.'p.id AND FIND_IN_SET('.$pf.'p.id, '.$pf.'f.producer_id) OR FIND_IN_SET('.$pf.'p.id, '.$pf.'f.director_id) OR FIND_IN_SET('.$pf.'p.id, '.$pf.'f.cast_id)'))
				->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
				->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
				->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
				->where('f.status', 1)
				->orderBy('f.created_at', 'desc')
				->groupBy('v.film_id');
			if($pos_id != 0){
				$query->where('p.id', $pos_id);
			}
			if($limit != 0){
				$query->take($limit);
			}
			$data = $query->get();
			if(!empty($data)){
				foreach($data as $item){
					$urlVideo = $title = '';
					if($item->url != ''){
						$urlVideo = Functions::getIdYoutubeFromUrl($item->url);
					}
					$title = $item->en_title;
					$url = $item->en_title_url;
					if($item->vn_title != ''){
						if($item->en_title != ''){
							$title = $title.' - '.$item->vn_title;
						}else{
							$title = $item->vn_title;
						}
						$url = $item->vn_title_url;
					}
					$responce[] = array(
						'id' => $item->id,
						'title' => $title,
						'url' => $url,
						'releaseDate' => $item->release_date,
						'poster' => $item->poster,
						'imdbPoint' => $item->imdb_rating,
						'view' => $item->view,
						'idYoutube' => $urlVideo,
						'ribbon' => $item->ribbon_id,
						'ribbonDescription' => $item->name
					);
				}
			}
			Cache::put($key, $responce, 360);
		}
		return $responce;
	}

	public static function getVideo($limit = 0){
		$responce = array();
		$key = 'blockFilm_'.$limit;
//		Cache::forget($key);
		if(Cache::has($key)){
			return Cache::get($key);
		}else{
			$pf = \DB::getTablePrefix();
			$query = DB::table('video as '.$pf.'v')
				->select('v.title','v.url')
				->where('cata_id', 2)
				->where('status', 1)
				->orderBy('v.created_at', 'desc');
			if($limit != 0){
				$query->take($limit);
			}
			$data = $query->get();
			if(!empty($data)){
				foreach($data as $item){
					$urlVideo = '';
					if($item->url != ''){
						$urlVideo = Functions::getIdYoutubeFromUrl($item->url);
					}
					$responce[] = array(
						'title' => $item->title,
						'idYoutube' => $urlVideo,
					);
				}
			}
			Cache::put($key, $responce, 360);
		}
		return $responce;
	}
	
	public static function getListCatalogue(){
		$responce = array();
		$key = 'blockCatalogue';
		Cache::forget($key);
		if(Cache::has($key)){
			return Cache::get($key);
		}else{
			$pf = \DB::getTablePrefix();
			$query = DB::table('catalogue_film as '.$pf.'c')
				->select('c.id','c.name','c.name_url');
			$data = $query->get();
			if(!empty($data)){
				foreach($data as $item){
					$responce[] = array(
						'id' => $item->id,
						'cata_name' => $item->name,
						'cata_url' => $item->name_url,
					);
				}
			}
			Cache::forever($key, $responce);
		}
		return $responce;
	}
}