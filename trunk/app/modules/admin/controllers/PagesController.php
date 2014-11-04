<?php
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Pages as PagesModel,
	App\Modules\Admin\Models\PageContents as PageContentsModel;

class PagesController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new PagesModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::page.list');
	}

	public function modify($id){
		$langs = \Config::get('custom/language.langs');
		$page = '';

		if($id != ''){
			$page = PagesModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($page == ''){
				$page = new PagesModel;
			}
			$data = \Input::get();
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';

			$rules = array(
				'code' => 'required|unique:pages,code,' . $id,
				'multilanguage_vi_title' => 'required',
				// 'multilanguage_en_title' => 'required',
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			if(isset($data['id'])){
				unset($data['id']);
			}
			unset($data['_token']);
			unset($data['confirm_password']);

			$contents = array();
			foreach($data as $field => $value){
				if(substr($field, 0, 13) != 'multilanguage'){
					$page->{$field} = $value;
				}else{
					$field = substr($field, 14);
					$lang_code = str_replace('_', '', substr($field, 0, 3));
					$field = substr($field, 3);
					$contents[$lang_code][$field] = $value;
				}
			}

			if($validator->fails()){
				return View::make('admin::page.form', array('page' => $page, 'id' => $id, 'langs' => $langs, 'error_messages' => $validator->messages()->toArray()));
			}

			\DB::beginTransaction();
			try{
				if($id == ''){
					$page->created_by = \Auth::admin()->user()->id;
					$page->updated_by = \Auth::admin()->user()->id;
				}else{
					$page->updated_by = \Auth::admin()->user()->id;
				}
				$page->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $page->id);
				}
				// add page content
				if(!empty($contents)){
					foreach($contents as $lang_code => $content){
						$page_content = new PageContentsModel;
						$page_content->page_id = $page->id;
						$page_content->lang_code = $lang_code;
						foreach($content as $field => $value){
							$page_content->{$field} = $value;
						}
						$page_content->save();
					}
				}
			}catch(\Exception $e){
				\DB::rollback();
				echo $e->getMessage();die;
			}
			\DB::commit();
			return \Redirect::route('pages.show')->with('success', '<strong>Success! </strong>Your action is done.');
		}

		return View::make('admin::page.form', array('page' => $page, 'id' => $id, 'langs' => $langs));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
	
}