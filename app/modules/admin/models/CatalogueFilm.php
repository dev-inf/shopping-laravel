<?php

namespace App\Modules\Admin\Models;

class CatalogueFilm extends \Eloquent {

	protected $table = 'catalogue_film';
	protected $tb_film = 'film';

	public function __construct() {
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'c';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'c.id','c.name','fM.total as total_movie', 'fD.total as total_drama');

		// join here
		$available_data = $available_data->leftJoin(\DB::raw('(SELECT B.id, COUNT(A.id) as total FROM '.\DB::getTablePrefix().$this->tb_film.' AS A, '.\DB::getTablePrefix().$this->table.' AS B WHERE A.sec_id = 1 AND FIND_IN_SET(B.id, A.cata_id) GROUP BY B.id) AS '.\DB::getTablePrefix().'fM'), 'fM.id', '=', 'c.id');
		$available_data = $available_data->leftJoin(\DB::raw('(SELECT B.id, COUNT(A.id) as total FROM '.\DB::getTablePrefix().$this->tb_film.' AS A, '.\DB::getTablePrefix().$this->table.' AS B WHERE A.sec_id = 2 AND FIND_IN_SET(B.id, A.cata_id) GROUP BY B.id) AS '.\DB::getTablePrefix().'fD'), 'fD.id', '=', 'c.id');
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
					$available_data = $available_data->where($column, $items['op'], $items['value']);
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
			$row['name'] = $data->name;
			$row['total_movie'] = $data->total_movie;
			$row['total_drama'] = $data->total_drama;
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
			$row['name'] = $item->name;
			$row['total_movie'] = $item->total_movie;
			$row['total_drama'] = $item->total_drama;
			$response[] = $row;
		}
		return $response;
	}

}
