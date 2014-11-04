<?php
Route::get('/', array('as' => '/', 'uses' => 'App\Modules\Maintenance\Controllers\IndexController@index'));
/* Created | 2014-07-25 | Hà Phan Minh | Subscribers */
Route::controller('/index/subscribers', 'App\Modules\Maintenance\Controllers\IndexController', ['getSubscribers' => 'index.subscribers']);
