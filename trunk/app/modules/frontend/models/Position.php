<?php
namespace App\Modules\Frontend\Models;

class Position extends \Eloquent{

	protected $table = 'position';

	public function __construct(){
		parent::__construct();
	}
	
	public function getDetail($id) {
		$prefix = \DB::getTablePrefix();
		$dataQuery = \DB::table('position as '.$prefix.'a')
				->select('a.id','a.fullname','a.fullname_url','a.fullname_vn','a.fullname_vn_url','a.nickname','a.avatar','a.date_of_birth','a.date_of_death','a.body_height','country','vn_description','b.name as cata_name','b.description as cata_description')
				->leftJoin('catalogue_position as '.$prefix.'b','b.id','=','a.cata_id')
				->where('a.id','=',$id)
				->get();
//		echo '<pre>';
//			print_r($dataQuery);
//		echo '</pre>';
//		die();
		$dataPosition = array();
		if(count($dataQuery) > 0){
			foreach($dataQuery as $item){
				$dataPosition = array(
					'id' => $item->id,
					'fullname' => $item->fullname,
					'fullname_url' => $item->fullname_url,
					'fullname_vn' => $item->fullname_vn,
					'fullname_vn_url' => $item->fullname_vn_url,
					'nickname' => $item->nickname,
					'avatar' => $item->avatar,
					'date_of_birth' => $item->date_of_birth,
					'date_of_death' => $item->date_of_death,
					'body_height' => $item->body_height,
					'country' => $item->country,
					'vn_description' => $item->vn_description,
					'cata_name' => $item->cata_name,
					'cata_description' => $item->cata_description
				);
			}
			
		}
//		echo '<pre>';
//			print_r($dataPosition);
//		echo '</pre>';
//		die();
		return $dataPosition;
	}

	public function getList($cata_url) {
		$prefix = \DB::getTablePrefix();
		$dataQuery = \DB::table('position as '.$prefix.'a')
				->select('a.id','a.fullname','a.fullname_url','a.fullname_vn','a.fullname_vn_url','a.avatar','b.name as cata_name','b.name_url as cata_url','b.description as cata_description')
				->leftJoin('catalogue_position as '.$prefix.'b','b.id','=','a.cata_id')
				->where('b.name_url','=',$cata_url)
				->where('a.idIMDB','<>',"")
				->where('a.avatar','<>',"")
				->orderBy('a.id','desc')
				->get();
//		echo '<pre>';
//			print_r($dataQuery);
//		echo '</pre>';
//		die();
		$dataPosition = array();
		if(count($dataQuery) > 0){
			$i = 0;
			foreach($dataQuery as $item){
				if($i == 0){
					$dataPosition['cata_name'] = $item->cata_name;
					$dataPosition['cata_description'] = $item->cata_description;
				}
				$dataPosition['data'][] = array(
					'id' => $item->id,
					'fullname' => $item->fullname,
					'fullname_url' => $item->fullname_url,
					'fullname_vn' => $item->fullname_vn,
					'fullname_vn_url' => $item->fullname_vn_url,
					'avatar' => $item->avatar,
					'cata_url' => $item->cata_url,
					'ribbon' => '',
					'ribbonDescription' => ''
				);
				$i++;
			}
			
		}
//		echo '<pre>';
//			print_r($dataPosition);
//		echo '</pre>';
//		die();
		return $dataPosition;
	}
}