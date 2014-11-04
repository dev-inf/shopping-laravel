<?php
namespace App\Modules\Admin\Models;

class FilmAccess extends \Eloquent{

	protected $table = 'film_access';

	public function __construct(){
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'access';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array('access.id',\DB::raw('IF(' . \DB::getTablePrefix() . 'access.en_title,' . \DB::getTablePrefix() . 'access.en_title,' . \DB::getTablePrefix() . 'access.vn_title) AS title'),'access.accessed_total as accessed');
		// if(@$params['selected_columns'] != ''){
		// 	$select = explode(',', $params['selected_columns']);
		// }
		
		$available_data = $available_data->select($select);

		// condition here
		$filters = $params['filter'];
		// $filters['u.id'] = array_shift($filterss);
		foreach($filters as $column => $items){
			foreach($items as $item){
				if(is_array($item)){
					if(!empty($item['value'])){
						$available_data = $available_data->where($column, $item['op'], $item['value']);
					}
					continue;
				}
			}
			if(!empty($items['value'])){
				if(strtolower($items['op']) == 'like'){
					$items['value'] = '%' . $items['value'] . '%';
				}
				$available_data = $available_data->where($column, $items['op'], $items['value']);
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
		$recordsFiltered = $available_data->count();

		// order here
		if(@$params['order'][0]['column'] != '' && @$params['order'][0]['dir'] != ''){
			$available_data = $available_data->orderBy($params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
		}

		$available_data = $available_data->take($params['length'])->offset($params['start'])->get();

		$response = array(
			'draw' => $params['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
		);
		foreach($available_data as $data){
			$row = array();
			$row['id'] = $data->id;
			$row['title'] = $data->title;
			$row['release_date'] = $data->release_date;
			$row['accessed'] = $data->accessed;
			$response['data'][] = $row;
		}
		return $response;
	}

	public function getExportData($params){
		$data = $this->prepareData($params);
		$data = $data['data'];
		$data = $data->get();
		return $data;
	}

}