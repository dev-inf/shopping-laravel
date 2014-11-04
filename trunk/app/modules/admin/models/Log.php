<?php

namespace App\Modules\Admin\Models;

class Log extends \Eloquent {

	protected $table = 'log_admincp';
	protected $tb_users = 'users';
	public $timestamps = false;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'l';
		$tb_users = $this->tb_users . ' AS ' . \DB::getTablePrefix() . 'u';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'l.id','l.action','l.message','l.time',\DB::raw('FROM_BASE64('.\DB::getTablePrefix().'l.user_id) AS user_id'),'u.username');
		// join here
		$available_data = $available_data->leftJoin($tb_users, \DB::raw('FROM_BASE64('.\DB::getTablePrefix().'l.user_id)'), '=', 'u.id');
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
			$userID = $data->user_id;
			$time = \Functions::decrypt($data->time,$userID);
			$time = substr($time, 0,10);
			$action = \Functions::decrypt($data->action,date('Ymd',$time));
			$message = \Functions::decrypt($data->message,date('Ymd',$time));
			$row['action'] = $action;
			$row['message'] = $message;
			$row['time'] = date('Y-m-d H:i:s',$time);
			$row['username'] = $data->username;
			$response['data'][] = $row;
		}
		return $response;
	}

}
