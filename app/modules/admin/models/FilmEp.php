<?php
namespace App\Modules\Admin\Models;

use App\Modules\Admin\Models\FilmSubtitle as FilmSubtitleModel;

class FilmEp extends \Eloquent{
	
	protected $table = 'film_ep';
	protected $tb_section_film = 'section_film';
	protected $tb_film = 'film';
	protected $tb_film_subtitle = 'film_subtitle';
	protected $tb_film_quality = 'film_quality';
	protected $tb_film_view = 'film_view';
	
	// protected $timestamp = false;

	public function __construct(){
		parent::__construct();
		$this->tb_section_film .= ' AS ' . \DB::getTablePrefix() . 'sec';
		$this->tb_film .= ' AS ' . \DB::getTablePrefix() . 'film';
		$this->tb_film_subtitle .= ' AS ' . \DB::getTablePrefix() . 'sub';
		$this->tb_film_quality .= ' AS ' . \DB::getTablePrefix() . 'qua';
		$this->tb_film_view .= ' AS ' . \DB::getTablePrefix() . 'view';
	}

	public function fromSubs(){
		return $this->hasMany(new FilmSubtitleModel, 'ep_id');
	}
	
	public function getData($params) {
		$table = $this->table . ' AS ' . \DB::getTablePrefix() . 'ep';
		$available_data = \DB::table($table);
		$recordsTotal = $available_data->count();
		
		$available_data = $available_data->leftJoin($this->tb_film, 'film.id', '=', 'ep.film_id');
		$available_data = $available_data->leftJoin($this->tb_section_film, 'sec.id', '=', 'film.sec_id');
		$available_data = $available_data->leftJoin($this->tb_film_subtitle, 'sub.ep_id', '=', 'ep.id');
		$available_data = $available_data->leftJoin($this->tb_film_quality, 'qua.id', '=', 'ep.quality_id');
		$available_data = $available_data->leftJoin($this->tb_film_view, 'view.ep_id', '=', 'ep.id');
		$available_data = $available_data->select('ep.id','sec.name AS section',\DB::raw('IF(' . \DB::getTablePrefix() . 'film.en_title != "",' . \DB::getTablePrefix() . 'film.en_title,' . \DB::getTablePrefix() . 'film.vn_title) AS title'),'ep.ep AS ep', 'ep.ep_link AS epLink', \DB::raw('IF(' . \DB::getTablePrefix() . 'ep.ep_link != "",1,0) AS link'), \DB::raw('COUNT(' . \DB::getTablePrefix() . 'sub.id) AS totalSub'), 'ep.time AS time', 'qua.code AS quality', 'view.total AS view','ep.status','film.id AS film_id');
		// $available_data = $available_data->select('ep.id','sec.name AS section',\DB::raw('IF(' . $prefix . 'film.en_title != "",' . $prefix . 'film.en_title,' . $prefix . 'film.vn_title) AS title'),'ep.ep AS ep', 'ep.ep_link AS epLink', \DB::raw('IF(' . $prefix . 'ep.ep_link != "",1,0) AS link'), \DB::raw('(SELECT COUNT(' . $prefix . 'film_subtitle.id) FROM ' . $prefix . 'film_subtitle WHERE ' . $prefix . 'film_subtitle.ep_id = ' . $prefix . 'ep.id) AS totalSub'), 'ep.time AS time', 'qua.code AS quality', 'view.total AS view');
		// $available_data = $available_data->from($table);

		// condition here
		$filters = $params['filter'];
		// $filters['u.id'] = array_shift($filterss);
		foreach ($filters as $column => $items) {
			foreach ($items as $item) {
				if (is_array($item)) {
					if (!empty($item['value'])) {
						$available_data = $available_data->where($column, $item['op'], $item['value']);
					}
					continue;
				}
			}
			if (!empty($items['value'])) {
				if (strtolower($items['op']) == 'like') {
					$items['value'] = '%' . $items['value'] . '%';
				}
				$available_data = $available_data->where($column, $items['op'], $items['value']);
			}
			// }
		}


		$recordsFiltered = $available_data->count();

		$available_data->groupBy('ep.id');

		// order here
		if (@$params['order'][0]['column'] != '' && @$params['order'][0]['dir'] != '') {
			$available_data = $available_data->orderBy('ep.'.$params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
		}

		$available_data = $available_data->take($params['length'])->offset($params['start'])->get();

// dd(\DB::getQueryLog());die;
		// $available_data = $this;
		// // join here
		// $available_data = $available_data->join($this->role_table, 'u.role', '=', 'r.id');
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
		foreach ($available_data as $data) {
			$viewTest = $data->film_id.'|'.$data->status.'|film';
			$row = array();
			$row['id'] = $data->id;
			$row['section'] = $data->section;
			$row['title'] = $data->title;
			$row['ep'] = $data->ep;
			$row['link'] = $data->link;
			$row['totalSub'] = $data->totalSub;
			$row['time'] = $data->time;
			$row['quality'] = $data->quality;
			$row['view'] = $data->view;
			$row['viewTest'] = $viewTest;
			$response['data'][] = $row;
		}
		return $response;
	}

}