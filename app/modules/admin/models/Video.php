<?php
namespace App\Modules\Admin\Models;

class Video extends \Eloquent{
	
	protected $table = 'video';
	protected $catalogue_table = 'catalogue_video';
	protected $table_alias = 'v';
	protected $catalogue_table_alias = 'c';

	public function __construct(){
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . $this->table_alias;
		$catalogue_table = $this->catalogue_table . ' AS ' . \DB::getTablePrefix() . $this->catalogue_table_alias;

		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),$this->table_alias . '.*', $this->catalogue_table_alias . '.name AS catalogue', $this->catalogue_table_alias . '.id AS cata_id');

		// join here
		$available_data = $available_data->leftJoin($catalogue_table, $this->catalogue_table_alias . '.id', '=', $this->table_alias . '.cata_id');
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
		$view = '';
		foreach($available_data as $data){
			$viewTest = $data->id.'|'.$data->status.'|video';
			$row = array();
			$row['id'] = $data->id;
			$row['url'] = $data->url;
			$row['title'] = $data->title;
			$row['idYoutube'] = $data->id_youtube;
			$row['viewYoutube'] = number_format($data->view_youtube);
			$row['duration'] = $data->duration;
			$row['catalogue'] = $data->catalogue;
			$row['status'] = $data->status;
			$row['viewTest'] = $viewTest;
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
			$row['url'] = $item->url;
			$row['title'] = $item->title;
			$row['idYoutube'] = $item->id_youtube;
			$row['viewYoutube'] = number_format($item->view_youtube);
			$row['duration'] = $data->duration;
			$row['catalogue'] = $item->catalogue;
			$row['status'] = $item->status;
			$response[] = $row;
		}
		return $response;
	}

}