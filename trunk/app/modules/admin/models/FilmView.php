<?php
namespace App\Modules\Admin\Models;

// use App\Modules\Admin\Models\Roles as Roles;

class FilmView extends \Eloquent{
	
	protected $table = 'film_view';
	
	// protected $timestamp = false;

	public function __construct(){
		parent::__construct();
	}

}