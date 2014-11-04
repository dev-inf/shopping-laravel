<?php
/*
 * Author: Hà Phan Minh
 * Created: 2014-08-04
 * Description: Class Event
 */
namespace App\Modules\Admin\Controllers;

use View,
	App\Modules\Admin\Models\Event as EventModel;

class EventController extends \BaseController{

	public function getShow(){
		if(\Request::ajax()){
			$params = \Input::get();
			
			$model = new EventModel;
			$response = $model->getData($params);

			return json_encode($response);
		}
		\Functions::saveLogAdmin(2);
		return View::make('admin::event.list');
	}

	public function modify($id){
		$event = '';

		if($id != ''){
			$event = EventModel::findOrFail($id);
		}

		if(\Request::isMethod('post')){
			if($event == ''){
				$event = new EventModel;
			}
			$data = \Input::get();

			$rules = array(
				'title' => 'required|unique:events,title,' . $id,
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$event->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('admin::event.form', array('event' => $event, 'id' => $id, 'error_messages' => $validator->messages()->toArray()));
			}

			try{
				if($id == ''){
					$event->created_by = \Auth::admin()->user()->id;
					$event->updated_by = \Auth::admin()->user()->id;
				}else{
					$event->updated_by = \Auth::admin()->user()->id;
				}
				$event->save();
				if($data['id'] != ''){
					\Functions::saveLogAdmin(4, $data['id']);
				}else{
					\Functions::saveLogAdmin(3, $event->id);
				}
				return \Redirect::route('event.show')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}

		return View::make('admin::event.form', array('event' => $event, 'id' => $id));
	}

	public function getModify($id = ''){
		return $this->modify($id);
	}

	public function postModify($id = ''){
		return $this->modify($id);
	}
}