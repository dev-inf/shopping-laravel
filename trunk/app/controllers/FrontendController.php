<?php

class FrontendController extends Controller {

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

}
