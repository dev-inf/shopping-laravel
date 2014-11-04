<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-06-05
 * Description: Class Position
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\CataloguePosition as CataloguePositionModel,
	App\Modules\Admin\Models\Position as PositionModel;

class PositionController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new PositionModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::position.list');
	}

	public function modify($id){
		$position = '';

		if($id != ''){
			$position = PositionModel::findOrFail($id);
		}
		
		$dataCataloguePosition = CataloguePositionModel::all()->toArray();
		$cataloguePosition[] = 'Choose Catalogue of Position';
		
		foreach($dataCataloguePosition as $item){
			$cataloguePosition[$item['id']] = $item['name'];
		}
		unset($dataCataloguePosition);

		if(\Request::isMethod('post')){
			if($position == ''){
				$position = new PositionModel;
			}
			$data = \Input::get();

			$rules = array(
				'fullname' => 'required',
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$position->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::position.form', array('position' => $position, 'cataloguePosition' => $cataloguePosition, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$position->created_by = \Auth::admin()->user()->id;
					$position->updated_by = \Auth::admin()->user()->id;
				}else{
					$position->updated_by = \Auth::admin()->user()->id;
				}
				$position->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $position->id);
				}
				return \Redirect::route('position.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::position.form', array('position' => $position, 'cataloguePosition' => $cataloguePosition, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
	
	public function postSearchDataPosition(){
		if(\Request::ajax()){
			$params = \Input::get();
			$results = \MyImdb::searchDataPositionByName($params['fullname']);
			$data = array();
			foreach ($results as $res) {
				$details = $res->getSearchDetails();
				$movie = '';
				if (!empty($details)) {
					$movie = $details["moviename"]." (".$details["year"].")";
				}
				$data[] = array(
					'id' => $res->imdbid(),
					'fullname' => $res->name(),
					'movie' => $movie
				);
			}
			return json_encode($data);
		}
	}
	
	public function postGetDetailPosition(){
		if(\Request::ajax()){
			$params = \Input::get();
			$position = \MyImdb::getDetailPosition($params['id']);
			$data['idIMDB'] = $params['id'];
			$data['fullname'] = $position->name();
			$data['avatar'] = '';
			if($position->photo_localurl() != FALSE){
				$data['avatar'] = $position->photo_localurl();
			}
			
			$birthday = $position->born();
			if (!empty($birthday)) {
				$data['country'] = $birthday["place"];
				$data['date_of_birth'] = str_replace('&nbsp;','',$birthday["day"])."/".str_replace('&nbsp;','',$birthday["month"])."/".str_replace('&nbsp;','',$birthday["year"]);
				$data['date_of_birth'] = \Functions::changeDate($data['date_of_birth']);
			}

			$death = $position->died();
			if (!empty($death)) {
				$data['date_of_death'] = str_replace('&nbsp;','',$death["day"])."/".str_replace('&nbsp;','',$death["month"])."/".str_replace('&nbsp;','',$death["year"]);
				$data['date_of_death'] = \Functions::changeDate($data['date_of_death']);
			}

			$nicks = $position->nickname();
			if (!empty($nicks)) {
				$data['nickname'] = str_replace('<br>',',',implode(',',$nicks));
				$data['nickname'] = explode(',',$data['nickname']);
			}

			$bh = $position->height();
			if (!empty($bh)) {
				$data['body_height'] = $bh["metric"];
			}

			$bio = $position->bio();
			if (!empty($bio)) {
				if (count($bio)<2) $idx = 0; else $idx = 1;
				$dataBio = preg_replace('/http\:\/\/'.str_replace(".","\.",$position->imdbsite).'\/name\/nm(\d{7})\//','?mid=\\1',$bio[$idx]["desc"])."<br />(Written by: ".$bio[$idx]['author']['name'].")";
				$data['en_description'] = $dataBio;
			}	
			return json_encode($data);
		}
	}

	public function postExport(){
		$params = \Input::get();
		$position = new PositionModel;
		$position = $position->getExportData($params);
		\Functions::export($position);
		die;
	}
	
	public function getGetAllPosition(){
		if(\Request::ajax()){
			$params = \Input::get();
			$data = PositionModel::where('fullname', 'LIKE', '%'.$params['q'].'%')
					->orWhere('fullname_vn', 'LIKE', '%'.$params['q'].'%')
					->where('cata_id', $params['cata_id'])->get(array('id', 'fullname as text'))->toArray();
			return json_encode($data);
		}
	}
}