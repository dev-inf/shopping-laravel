<?php
namespace App\Modules\Admin\Models;


class Ribbon extends \Eloquent{

	protected $table = 'ribbon';
	protected $tb_film = 'film';

	public function __construct(){
		parent::__construct();
	}

  	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'r';
		$tb_film = $this->tb_film . ' AS ' . \DB::getTablePrefix() . 'f';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'r.id','r.name','r.from','r.to',\DB::raw('COUNT('.\DB::getTablePrefix().'f.id) as total_film'));
		// join here
		$available_data = $available_data->leftJoin($tb_film, 'f.ribbon_id', '=', 'r.id');
		$available_data = $available_data->select($select);
		$available_data = $available_data->groupBy('r.id');

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
			$row['from'] = $data->from;
			$row['to'] = $data->to;
			$row['total_film'] = $data->total_film;
			$response['data'][] = $row;
		}
		return $response;
	}
}