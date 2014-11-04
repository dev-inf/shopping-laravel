<?php
namespace App\Modules\Frontend\Models;

class Catalogue extends \Eloquent{

	protected $table = 'catalogue_film';

	public function __construct(){
		parent::__construct();
	}

	public function getList($id,$cata_url) {
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
//		$dataQuery = \DB::table('catalogue_film as '.$prefix.'a')
//				->select('a.id','a.fullname','a.fullname_url','a.fullname_vn','a.fullname_vn_url','a.avatar','b.name as cata_name','b.name_url as cata_url','b.description as cata_description')
//				->leftJoin('catalogue_position as '.$prefix.'b','b.id','=','a.cata_id')
//				->where('b.name_url','=',$cata_url)
//				->where('a.idIMDB','<>',"")
//				->where('a.avatar','<>',"")
//				->orderBy('a.id','desc')
//				->get();
		$dataQuery = \DB::table('film as '.$pf.'f')
					->select($fieldSelect,\DB::raw('SUM('.$pf.'v.total) as view'))
					->leftJoin('catalogue_film as '.$pf.'c', 'c.id','=',\DB::raw($pf.'c.id AND FIND_IN_SET('.$pf.'c.id, '.$pf.'f.cata_id)'))
					->leftJoin('video as '.$pf.'vi', 'vi.film_id', '=', 'f.id')
					->leftJoin('ribbon as '.$pf.'r', 'r.id', '=', 'f.ribbon_id')
					->leftJoin('film_view as '.$pf.'v', 'v.film_id', '=', 'f.id')
					->where('f.status', 1)
					->where('c.id', $id)
					->orderBy('f.created_at', 'desc')
					->groupBy('v.film_id')
					->get();
//		echo '<pre>';
//			print_r($dataQuery);
//		echo '</pre>';
//		die();
		$dataCatalogue = array();
		if(count($dataQuery) > 0){
			foreach($dataQuery as $item){
				$urlVideo = $title = '';
				if($item->url != ''){
					$urlVideo = \Functions::getIdYoutubeFromUrl($item->url);
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
				$dataCatalogue[] = array(
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
//		echo '<pre>';
//			print_r($dataCatalogue);
//		echo '</pre>';
//		die();
		return $dataCatalogue;
	}
}