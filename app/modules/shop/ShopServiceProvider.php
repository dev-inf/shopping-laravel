<?php
namespace App\Modules\Shop;

class ShopServiceProvider extends \Illuminate\Support\ServiceProvider{

	public function register(){
		\Log::debug("ShopServiceProvider registered");
	}

}