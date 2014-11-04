<?php

Route::get('/auth/login', array('as' => 'login', 'before' => 'isLogin', 'uses' => 'App\Modules\Auth\Controllers\IndexController@login'));
Route::post('/auth/login', array('as' => 'login.post', 'before' => 'isLogin', 'uses' => 'App\Modules\Auth\Controllers\IndexController@login'));
Route::get('/auth/logout', array('as' => 'logout', 'uses' => 'App\Modules\Auth\Controllers\IndexController@logout'));
Route::get('/auth/customer/login', array('as' => 'customer.login', 'before' => '', 'uses' => 'App\Modules\Auth\Controllers\CustomerController@login'));
Route::post('/auth/customer/login', array('as' => 'customer.login.post', 'before' => '', 'uses' => 'App\Modules\Auth\Controllers\CustomerController@login'));
Route::get('/auth/customer/logout', array('as' => 'customer.logout', 'uses' => 'App\Modules\Auth\Controllers\CustomerController@logout'));
