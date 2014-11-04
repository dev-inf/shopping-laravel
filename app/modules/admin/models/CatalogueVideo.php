<?php
namespace App\Modules\Admin\Models;

// use App\Modules\Admin\Models\Roles as Roles;

class CatalogueVideo extends \Eloquent{

	protected $table = 'catalogue_video';
	protected $tb_video = 'video';

	public function __construct(){
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'c';
		$tb_video = $this->tb_video . ' AS ' . \DB::getTablePrefix() . 'v';

		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'c.id','c.name',\DB::raw('COUNT('.\DB::getTablePrefix().'v.id) as total_video'));

		// join here
		$available_data = $available_data->leftJoin($tb_video, 'v.cata_id', '=', 'c.id');
		$available_data = $available_data->select($select);
		$available_data = $available_data->groupBy('c.id');

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
			$row['total_video'] = $data->total_video;
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
			$row['total_video'] = $item->total_video;
			$response[] = $row;
		}
		return $response;
	}

}