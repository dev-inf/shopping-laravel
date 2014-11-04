<?php
namespace App\Modules\Admin\Models;

// use App\Modules\Admin\Models\Roles as Roles;

class Pages extends \Eloquent{

	protected $table = 'pages';
	protected $content_table = 'page_contents';
	protected $table_alias = 'p';
	protected $content_table_alias = 'c';
	// protected $timestamp = false;

	public function __construct(){
		parent::__construct();
	}

	public function getData($params){
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . $this->table_alias;
		$content_table = $this->content_table . ' AS ' . \DB::getTablePrefix() . $this->content_table_alias;
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();

		// join here
		$available_data = $available_data->leftJoin($content_table, 'p.id', '=', 'c.page_id');
		$available_data = $available_data->select('p.*', 'c.title AS title');

		// condition here
		$available_data = $available_data->where('lang_code', '=', 'vi');
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
			// }
		}
		

		$recordsFiltered = $available_data->count();

		// order here
		if(@$params['order'][0]['column'] != '' && @$params['order'][0]['dir'] != ''){
			$available_data = $available_data->orderBy($this->table_alias . '.'.$params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
		}

		$available_data = $available_data->take($params['length'])->offset($params['start'])->get();
	
// dd(\DB::getQueryLog());die;


		// $available_data = $this;
		// // join here
		// $available_data = $available_data->join($content_table, 'u.role', '=', 'r.id');
		// $available_data = $available_data->select('r.name AS name');

		// // condition here
		// // $available_data = $this->whereRaw('', '', '1 = 1');


		// // order here
		// if(@$params['order'][0]['column'] != '' && @$params['order'][0]['dir'] != ''){
		// 	$available_data = $this->orderBy($params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
		// }

		// $available_data = $available_data->take($params['length'])->offset($params['start'])->get();

		$response = array(
			'draw' => $params['draw'],
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $recordsFiltered,
			"data" => array(),
		);
		foreach($available_data as $data){
			$row = array();
			$row['id'] = $data->id;

			$row['code'] = $data->code;

			$row['title'] = $data->title;

			$row['status'] = $data->status;
			
			$response['data'][] = $row;
		}
		return $response;
	}

}