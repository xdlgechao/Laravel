<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class AdminController extends Controller
{
    /**
     * 后台首页
     */
    public function index()
    {
    	return view('admin.index');
    }

    /**
     * 后台登陆页面显示
     */
    public function login()
    {
    	return view('admin.login');
    }

    /**
     * 登陆操作
     */
    public function doLogin(Request $request)
    {
    	//获取参数
    	$username = $request->input('username');
    	$password = $request->input('password');

    	//检索数据库
    	$info = User::where('username',$username)->first();

    	//检测
    	if(empty($info)){
    		return back()->with('error','用户名不存在');
    	}
    	//检测密码
    	if(Hash::check($password, $info['password'])){
    		//写入session信息
    		session(['uid'=>$info['id']]);
    		//跳转后台首页
    		return redirect('/admin');
    	}

    	return back()->with('error','密码错误');
    }
}
