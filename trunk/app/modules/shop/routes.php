<?php

Route::get('/products', 'App\Modules\Shop\Controllers\ShopController@index');//    array('as' =>'products', 'uses' => 'App\Modules\Shop\Controllers\ShopController@index'));
// Route::post('login', array('as' => 'login.post', 'uses' => 'App\Modules\Shop\Controllers\ShopController@postLogin'));
// Route::get('logout', array('as' => 'logout',     'uses' => 'App\Modules\Shop\Controllers\ShopController@getLogout'));