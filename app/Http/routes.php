<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Event::listen('illuminate.query',function($query){
     // var_dump($query);
});


Route::get('/admin/login','AdminController@login');
Route::post('/admin/login','AdminController@doLogin');

Route::group(['middleware'=>'login'], function(){
	
	//后台首页
	Route::get('/admin', 'AdminController@index');

	//用户的管理
	Route::controller('/admin/user', 'UserController');

	//分类管理
	Route::controller('/admin/cate', 'CateController');

	//文章管理
	Route::get('admin/article/ajax-update', 'ArticleController@ajaxUpdate');
	Route::get('admin/article/delete/{id}', 'ArticleController@destroy');
	Route::resource('/admin/article', 'ArticleController');

	//商品管理
	Route::controller('/admin/goods','GoodsController');

	//图片管理
	Route::controller('/admin/images','ImageController');

});
