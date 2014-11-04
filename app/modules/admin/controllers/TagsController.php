<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-07-21
 * Description: Class Tags
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Tags as TagsModel;

class TagsController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new TagsModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::tags.list');
	}

	public function modify($id){
		$tags = '';

		if($id != ''){
			$tags = TagsModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($tags == ''){
				$tags = new TagsModel;
			}
			$data = \Input::get();

			$rules = array(
				'name' => 'required|unique:tags,name,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$tags->{$field} = $value;
				$tags->url = \Functions::strToUrl($value);
			}
			if($validator->fails()){
				return View::make('admin::sectionFilm.form', array('tags' => $tags, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$tags->created_by = \Auth::admin()->user()->id;
					$tags->updated_by = \Auth::admin()->user()->id;
				}else{
					$tags->updated_by = \Auth::admin()->user()->id;
				}
				$tags->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $tags->id);
				}
				return \Redirect::route('tags.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::tags.form', array('tags' => $tags, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
	
	public function getGetAllTags(){
		if(\Request::ajax()){
			$params = \Input::get();
			$data = TagsModel::where('name', 'LIKE', '%'.$params['q'].'%')->get(array('id', 'name as text'))->toArray();
			return json_encode($data);
		}
	}
}