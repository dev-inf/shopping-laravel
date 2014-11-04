<?php
namespace App\Modules\Admin\Models;

class Position extends \Eloquent{
	
	protected $table = 'position';
	protected $tb_catalogue_position = 'catalogue_position';
	protected $tb_film = 'film';

	public function __construct(){
		parent::__construct();
	}

	public function prepareData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'pos';
		$tb_catalogue_position = $this->tb_catalogue_position . ' AS ' . \DB::getTablePrefix() . 'cata';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// seleted columns
		$select = array(\DB::raw('SQL_CALC_FOUND_ROWS "tmp"'),'pos.id','cata.name as catalogue','pos.avatar AS image','pos.fullname','pos.date_of_birth','pos.country','TTF.total_film');

		// join here
		$available_data = $available_data->leftJoin($tb_catalogue_position, 'pos.cata_id','=','cata.id');
		$available_data = $available_data->leftJoin(\DB::raw(''
				. '(SELECT TT.id, SUM(TT.total) AS total_film FROM '
				. '	(SELECT B.id, COUNT(A.id) as total FROM '.\DB::getTablePrefix().$this->tb_film.' AS A, '.\DB::getTablePrefix().$this->table.' AS B WHERE FIND_IN_SET(B.id, A.producer_id) GROUP BY B.id'
				. ' UNION ALL'
				. '	SELECT B.id, COUNT(A.id) as total FROM '.\DB::getTablePrefix().$this->tb_film.' AS A, '.\DB::getTablePrefix().$this->table.' AS B WHERE FIND_IN_SET(B.id, A.director_id) GROUP BY B.id'
				. ' UNION ALL'
				. ' SELECT B.id, COUNT(A.id) as total FROM '.\DB::getTablePrefix().$this->tb_film.' AS A, '.\DB::getTablePrefix().$this->table.' AS B WHERE FIND_IN_SET(B.id, A.cast_id) GROUP BY B.id'
				. ') AS TT'
				. ' GROUP BY TT.id'
				. ') AS '.\DB::getTablePrefix().'TTF'
				), 'TTF.id', '=', 'pos.id');
		$available_data = $available_data->select($select);
		$available_data = $available_data->groupBy('pos.id');

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
			$row['catalogue'] = $data->catalogue;
			$row['image'] = $data->image;
			$row['fullname'] = $data->fullname;
			$row['date_of_birth'] = $data->date_of_birth;
			$row['country'] = $data->country;
			$row['total_film'] = $data->total_film;
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
			$row['catalogue'] = $item->catalogue;
			$row['fullname'] = $item->fullname;
			$row['date_of_birth'] = $item->date_of_birth;
			$row['country'] = $item->country;
			$row['total_film'] = $item->total_film;
			$response[] = $row;
		}
		return $response;
	}
}