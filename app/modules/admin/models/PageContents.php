<?php
namespace App\Modules\Admin\Models;

// use App\Modules\Admin\Models\Roles as Roles;

class PageContents extends \Eloquent{

	protected $table = 'page_contents';
	
	public $timestamps = false;

	public function __construct(){
		parent::__construct();
	}

	public function fromPage(){
		return $this->belongsTo(new Pages);
	}
}