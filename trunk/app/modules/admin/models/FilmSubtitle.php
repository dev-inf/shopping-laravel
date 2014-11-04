<?php
namespace App\Modules\Admin\Models;

class FilmSubtitle extends \Eloquent{

	protected $table = 'film_subtitle';
	protected $tb_section_film = 'section_film';
	protected $tb_film = 'film';
	protected $tb_film_ep = 'film_ep';
	protected $tb_language = 'language';

	public function __construct(){
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'sub';
		$tb_section_film = $this->tb_section_film . ' AS ' . \DB::getTablePrefix() . 'sec';
		$tb_film = $this->tb_film . ' AS ' . \DB::getTablePrefix() . 'film';
		$tb_film_ep = $this->tb_film_ep . ' AS ' . \DB::getTablePrefix() . 'ep';
		$tb_language = $this->tb_language . ' AS ' . \DB::getTablePrefix() . 'lang';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'sub.id', 'sec.name AS section',\DB::raw('IF(' . \DB::getTablePrefix() . 'film.en_title != "",' . \DB::getTablePrefix() . 'film.en_title,' . \DB::getTablePrefix() . 'film.vn_title) AS title, IF(' . \DB::getTablePrefix() . 'sub.subtitle_url,1,0) AS subtitle'), 'ep.ep AS ep', 'sub.subtitle_url AS subLink', \DB::raw('IF(' . \DB::getTablePrefix() . 'sub.subtitle_url != "",1,0) AS link'), 'lang.name AS language');

		// join here
		$available_data = $available_data->leftJoin($tb_film_ep, 'ep.id', '=', 'sub.ep_id');
		$available_data = $available_data->leftJoin($tb_film, 'film.id', '=', 'ep.film_id');
		$available_data = $available_data->leftJoin($tb_section_film, 'sec.id', '=', 'film.sec_id');
		$available_data = $available_data->leftJoin($tb_language, 'lang.id', '=', 'sub.lang_id');
		$available_data = $available_data->select($select);
		

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
				}else{
					continue;
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

	public function getData($params){		
		$available_data = $this->prepareData($params);
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
			$row['section'] = $data->section;
			$row['title'] = $data->title;
			$row['ep'] = $data->ep;
			$row['link'] = $data->link;
			$row['subtitle'] = $data->subtitle;
			$row['language'] = $data->language;
			$response['data'][] = $row;
		}
		return $response;
	}

	public function getExportData($params){
		$data = $this->prepareData($params);
		$data = $data['data'];
		$data = $data->get();
		foreach($data as $item){
			$row = array();
			$row['id'] = $item->id;
			$row['section'] = $item->section;
			$row['title'] = $item->title;
			$row['ep'] = $item->ep;
			$row['link'] = $item->link;
			$row['subtitle'] = $item->subtitle;
			$row['language'] = $item->language;
			$response[] = $row;
		}
		return $response;
	}
}