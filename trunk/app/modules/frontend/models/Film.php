<?php
namespace App\Modules\Frontend\Models;

class Film extends \Eloquent{

	protected $table = 'film';

	public function __construct(){
		parent::__construct();
	}
	
	public function getDetail($id) {
		$prefix = \DB::getTablePrefix();
		$dataQuery = \DB::table('film as '.$prefix.'a')
				->select('a.id', 'a.en_title','a.vn_title','a.release_date','a.poster','a.banner','a.vn_description','a.imdb_rating','a.cata_id','b.id as ep_id','b.ep','b.ep_link','c.ep_id as ep_id_sub','c.id as sub_id','c.subtitle_url','d.name as country', 'd.code as lang_code','e.fullname','e.fullname_url','e.cata_name','e.cata_url','e.id as pos_id','f.id_youtube')
				->leftJoin('film_ep as '.$prefix.'b','a.id', '=', 'b.film_id')
				->leftJoin('film_subtitle as '.$prefix.'c','b.id', '=', 'c.ep_id')
				->leftJoin('language as '.$prefix.'d','c.lang_id', '=', 'd.id')
				->leftJoin(\DB::raw('(SELECT a.*, b.name as cata_name, b.name_url as cata_url FROM '.$prefix.'position AS a, '.$prefix.'catalogue_position AS b WHERE a.cata_id = b.id) as '.$prefix.'e'),'e.id','=',\DB::raw($prefix.'e.id AND FIND_IN_SET('.$prefix.'e.id, '.$prefix.'a.producer_id) OR FIND_IN_SET('.$prefix.'e.id, '.$prefix.'a.director_id) OR FIND_IN_SET('.$prefix.'e.id, '.$prefix.'a.cast_id)'))
				->leftJoin('video as '.$prefix.'f','f.film_id', '=', 'a.id')
				->where('a.id','=',$id)
				->get();
		
//		echo '<pre>';
//			print_r($dataQuery);
//		echo '</pre>';
//		die();
		$dataFilm = array();
		if(count($dataQuery) > 0){
			$i = 0;
			$oldEpId = 0;
			foreach($dataQuery as $item){
				if($i == 0){
					$dataFilm = array(
						'id' => $item->id,
						'en_title' => $item->en_title,
						'vn_title' => $item->vn_title,
						'release_date' => $item->release_date,
						'cata_id' => $item->cata_id,
						'poster' => $item->poster,
						'banner' => $item->banner,
						'imdb_rating' => $item->imdb_rating,
						'description' => $item->vn_description,
						'id_youtube' => $item->id_youtube
					);
					$dataFilm['epFirst'] = array(
						'ep' => $item->ep,
						'link' => $item->ep_link
					);
				}else{
					if($item->ep == 0){
						if($item->ep_id != $oldEpId){
							$dataFilm['dataEpOther'][$item->ep_id] = array(
								'ep' => $item->ep,
								'link' => $item->ep_link
							);
						}
					}else{
						$dataFilm['dataEpDrama'][$item->ep_id] = array(
							'ep' => $item->ep,
							'link' => $item->ep_link
						);
					}
				}
				$dataFilm['position'][$item->cata_name][] = array(
					'fullname' => $item->fullname,
					'fullname_url' => $item->fullname_url,
					'cata_url' => $item->cata_url,
					'pos_id' => $item->pos_id
				);
				$i++;
				$oldEpId = $item->ep_id;
			}
			
		}
//		echo '<pre>';
//			print_r($dataFilm);
//		echo '</pre>';
//		die();
		return $dataFilm;
	}
}