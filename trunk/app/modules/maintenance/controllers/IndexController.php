<?php
namespace App\Modules\Maintenance\Controllers;

use View,
	App\Modules\Maintenance\Models\Subscribers as SubscribersModel;

class IndexController extends \HomeController{

	public function index(){
//		echo 'hello';die;
		return View::make('maintenance::index.index');
	}
	
	public function getSubscribers(){
		if(\Request::isMethod('post')){
			$subscribers = new SubscribersModel;
			
			$data = \Input::get();

			$rules = array(
				'email' => 'required|unique:subscribers,email',
			);

			$validator = \Validator::make($data, $rules);

			unset($data['ok']);
			unset($data['_token']);

			foreach($data as $field => $value){
				$subscribers->{$field} = $value;
			}
			if($validator->fails()){
				return View::make('maintenance::index.form', array('error_messages' => $validator->messages()->toArray()));
			}

			try{
				$subscribers->save();
				return \Redirect::route('/')->with('success', '<strong>Success! </strong>Your action is done.');
			}catch(\Exception $e){
				echo $e->getMessage();die;
			}
		}
	}

}