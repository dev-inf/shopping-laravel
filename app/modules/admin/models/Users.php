<?php
namespace App\Modules\Admin\Models;

class Users extends \Eloquent{

	protected $table = 'users';
	protected $tb_gender = 'gender';
	protected $role_table = 'roles';
	protected $table_alias = 'u';
	protected $role_table_alias = 'r';

	public function __construct(){
		parent::__construct();
		$this->tb_gender .= ' AS ' . \DB::getTablePrefix() . 'g';
	}

	public function fromRole(){
		return $this->belongsTo(new Roles, 'roles');
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . $this->table_alias;
		$role_table = $this->role_table . ' AS ' . \DB::getTablePrefix() . $this->role_table_alias;
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array('u.*', 'g.name AS gender', 'r.name AS role_name', 'r.id AS role_id');
		if(@$params['selected_columns'] != ''){
			$select = explode(',', $params['selected_columns']);
		}

		// join here
		$available_data = $available_data->leftJoin($role_table, 'u.role', '=', 'r.id');
		$available_data = $available_data->leftJoin($this->tb_gender, 'g.id', '=', 'u.gender_id');
		$available_data = $available_data->select($select);

		// condition here
		$filters = $params['filter'];
		// $filters['u.id'] = array_shift($filterss);
		$available_data = $available_data->where('r.id', '!=', '1');
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

			$row['username'] = $data->username;
			$row['fullname'] = $data->fullname;
			$row['email'] = $data->email;
			$row['gender'] = $data->gender;
			$row['phone'] = $data->phone;
			$row['role'] = $data->role_name;
			$row['role_id'] = $data->role_id;

			$row['status'] = $data->status;
			
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