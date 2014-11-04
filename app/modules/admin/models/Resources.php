<?php
namespace App\Modules\Admin\Models;

class Resources extends \Eloquent{

	protected $table = 'resources';
	public $timestamps = false;

	public function __construct(){
		parent::__construct();
		// $this->table = \DB::getTablePrefix() . 'resources';
	}

	public function parent(){
		return $this->belongsTo(new Resources, 'parent');
	}

	public function children(){
		return $this->hasMany(new Resources, 'parent');
	}

	public function prepareData($params){
		// $table = $this->table . ' AS ' . \DB::getTablePrefix() . $this->table_alias;
		$available_data = \DB::table($this->table);
		$recordsTotal = $available_data->count();

		// seleted columns
		// $select = array('u.*', 'g.name AS gender', 'r.name AS role_name', 'r.id AS role_id');
		// if(@$params['selected_columns'] != ''){
		// 	$select = explode(',', $params['selected_columns']);
		// }

		// join here
		// $available_data = $available_data->select($select);

		// condition here
		$filters = $params['filter'];
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
					if(strtolower($items['op']) != 'in'){
						$available_data = $available_data->where($column, $items['op'], $items['value']);
					}else{
						$available_data = $available_data->whereIn($column, $items['value']);						
					}
				}
			// }
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
		}else{
			$available_data = $available_data->orderBy('name', 'desc');
		}

		$available_data = $available_data->take($params['length'])->offset($params['start'])->get();
// $query = \DB::getQueryLog();
// print_r($query);die;
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
			$row['action'] = $data->action;
			
			$response['data'][] = $row;
		}
		return $response;
	}

}