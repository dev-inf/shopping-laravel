<?php

class BaseController extends Controller {

	protected $module = '';
	protected $controller = '';
	protected $action = '';

	public function __construct(){
		$this-> getCurrentInfoMVC();
	}

	protected function getCurrentInfoMVC(){

		$path = \Route::currentRouteAction();
		$path = explode('\\', $path);
		if(@$path['1'] == 'Modules'){
			$this->module = $path['2'];
		}
		$controller_action = end($path);
		$controller_action = explode('@', $controller_action);

		$this->controller = str_replace('Controller', '', $controller_action['0']);
		$this->action = $controller_action['1'];

		$currentMvc = array(
			'module' => $this->module,
			'controller' => $this->controller,
			'action' => $this->action,
		);
		\View::share('currentMvc', $currentMvc);	
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function getChangeStatus(){
		if(\Request::ajax()){
			$resp = array();
			$data = \Input::get();
			$object = '\App\Modules\Admin\Models\\' . ucfirst($data['table']);
			$object = $object::findOrFail($data['id']);
			$object->status = $data['status'];
			$object->save();
			$resp['status'] = '00';
			$resp['message'] = 'success';
			return json_encode($resp);
		}
	}

	public function getDelete(){
		if(\Request::ajax()){
				$resp = array();
				// begin transaction
				\DB::beginTransaction();
				$data = \Input::get();
				$table = $data['table'];
				$ids = $data['ids'];
				unset($data);

				if(!empty($ids)){
					foreach($ids as $id){
						$object = '\App\Modules\Admin\Models\\' . ucfirst($table);

						try{
							if($table == 'configuration'){
								$table = 'system_registries';
								$test = $object::from($table)->where('id', '=', $id)->first();//->delete();
								\Registry::forget($test->key);
							}
							$test = $object::from($table)->where('id', '=', $id)->delete();
							\Functions::saveLogAdmin(5, $id);
							$resp['status'] = '00';
							$resp['message'] = 'success';
						}catch(\Exception $e){
							\DB::rollback(); //
							$rule = '/with message \'(.*)\:/';
							preg_match($rule, $e, $match);
							print_r($match);die;
							$resp['status'] = '';
							$resp['message'] = $e->getMessage();
						}

					}
					\DB::commit(); // commit if success
				}
			return json_encode($resp);
		}
	}

}
