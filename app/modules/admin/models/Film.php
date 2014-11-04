<?php
namespace App\Modules\Admin\Models;

class Film extends \Eloquent{

	protected $table = 'film';
	protected $tb_catalogue_film = 'catalogue_film';
	protected $tb_film_ep = 'film_ep';
	protected $tb_film_subtitle = 'film_subtitle';
	protected $tb_film_view = 'film_view';

	public function __construct(){
		parent::__construct();	
	}

	public function fromSection(){
		return $this->belongsTo(new SectionFilm, 'sec_id');
	}
	
	public function prepareData($params, $sectionFilm){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'film';
		$tb_catalogue_film = $this->tb_catalogue_film .= ' AS ' . \DB::getTablePrefix() . 'cata';
		$tb_film_ep = $this->tb_film_ep .= ' AS ' . \DB::getTablePrefix() . 'ep';
		$tb_film_subtitle = $this->tb_film_subtitle .= ' AS ' . \DB::getTablePrefix() . 'sub';
		$tb_film_view = $this->tb_film_view .= ' AS ' . \DB::getTablePrefix() . 'view';
		$available_data = \DB::table($table)->where('film.sec_id','=',$sectionFilm);
		$recordsTotal = $available_data->count();
		$condition = '';
		if($sectionFilm == 2){
			$condition = ', COUNT(' . \DB::getTablePrefix() . 'view.ep_id) as ep';
		}
		
		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'film.id','film.poster','film.en_title','film.vn_title','film.release_date','film.status','film.depute','film.coming',\DB::raw('IF(' . \DB::getTablePrefix() . 'film.banner != "",1,0) AS banner, IF(' . \DB::getTablePrefix() . 'film.producer_id != "",1,0) as producer, IF(' . \DB::getTablePrefix() . 'film.director_id != "",1,0) as director, IF(' . \DB::getTablePrefix() . 'film.cast_id != "",1,0) as cast, IF(' . \DB::getTablePrefix() . 'ep.ep_link != "",1,0) AS ep, IF(' . \DB::getTablePrefix() . 'sub.subtitle_url != "",1,0) AS sub, IF(' . \DB::getTablePrefix() . 'film.imdb_rating != "" AND ' . \DB::getTablePrefix() . 'film.imdb_vote != "",1,0) as imdb, COALESCE(SUM(' . \DB::getTablePrefix() . 'view.total), 0) as total_view '.$condition));

		// join here
		$available_data = $available_data->leftJoin($tb_catalogue_film, 'cata.id', '=', 'film.cata_id');
		$available_data = $available_data->leftJoin($tb_film_ep, 'ep.film_id', '=', 'film.id');
		$available_data = $available_data->leftJoin($tb_film_subtitle, 'sub.ep_id', '=', 'ep.id');
		$available_data = $available_data->leftJoin($tb_film_view, 'view.ep_id', '=', 'ep.id');
		$available_data = $available_data->select($select);
		$available_data = $available_data->where('film.sec_id','=',$sectionFilm);
		$available_data = $available_data->groupBy('film.id');

		// condition here
		$filters = $params['filter'];

		foreach ($filters as $column => $items) {
			foreach ($items as $index => $item) {
				if (is_array($item)) {
					if ($item['value'] != '') {
						if(substr($column, 0, 6) != 'total_'){							
							$available_data = $available_data->where($column, $item['op'], $item['value']);
						}else{
							$available_data = $available_data->having($column, $item['op'], $item['value']);							
						}
					}
				}
			}
			if (!empty($items['value'])) {
				if (strtolower($items['op']) == 'like') {
					$items['value'] = '%' . $items['value'] . '%';
				}
				if(strtolower($items['op']) != 'in'){
					if($column == 'title'){								
						$available_data = $available_data->where('film.en_title', $items['op'], $items['value'])
																							->orWhere('film.vn_title', $items['op'], $items['value']);
					}else{
						$available_data = $available_data->where($column, $items['op'], $items['value']);
					}
				}else{
					$available_data = $available_data->whereIn($column, $items['value']);						
				}
			}
		}

		return array(
			'recordsTotal' => $recordsTotal,
			'data' => $available_data,
		);
	}

	public function getData($params, $sectionFilm){		
		$available_data = $this->prepareData($params, $sectionFilm);
		$recordsTotal = $available_data['recordsTotal'];
		$available_data = $available_data['data'];

		// order here
		if(@$params['order'][0]['column'] != '' && @$params['order'][0]['dir'] != ''){
			$available_data = $available_data->orderBy($params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
		}

		$available_data = $available_data->take($params['length'])->offset($params['start'])->get();
		// $query = \DB::getQueryLog();
		// print_r($query);die;
		$recordsFiltered = \DB::select('SELECT FOUND_ROWS() AS found_row');
		$recordsFiltered = $recordsFiltered[0]->found_row;

		$response = array(
			'draw' => $params['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
		);
		foreach($available_data as $data){
			$row = array();
			$row['id'] = $data->id;
			$row['title'] = $data->en_title.'|'.$data->vn_title;
			$row['poster'] = $data->poster;
			$row['release_date'] = $data->release_date;
			$row['banner'] = $data->banner;
			$row['producer'] = $data->producer;
			$row['director'] = $data->director;
			$row['cast'] = $data->cast;
			$row['ep'] = $data->ep;
			$row['sub'] = $data->sub;
			$row['status'] = $data->status;
			$row['coming'] = $data->coming;
			$row['depute'] = $data->depute;
			$row['imdb'] = $data->imdb;
			if($sectionFilm == 5){
				$row['ep'] = $data->ep;
			}
			$row['total_view'] = $data->total_view;
			$response['data'][] = $row;
		}
		return $response;
	}

	public function getExportData($params, $sectionFilm){
		$data = $this->prepareData($params, $sectionFilm);
		$data = $data['data'];
		$data = $data->get();
		foreach($data as $item){
			$row = array();
			$row['id'] = $item->id;
			$row['title'] = $item->en_title.' ('.$item->vn_title.')';
			$row['release_date'] = $item->release_date;
			$row['poster'] = $item->poster;
			$row['banner'] = $item->banner;
			$row['producer'] = $item->producer;
			$row['director'] = $item->director;
			$row['cast'] = $item->cast;
			$row['ep'] = $item->ep;
			$row['sub'] = $item->sub;
			$row['imdb'] = $item->imdb;
			if($sectionFilm == 5){
				$row['ep'] = $item->ep;
			}
			$row['total_view'] = $item->total_view;
			$response[] = $row;
		}
		return $response;
	}
}