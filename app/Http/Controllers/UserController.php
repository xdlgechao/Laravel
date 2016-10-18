<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 显示添加页面
     */
    public function getAdd()
    {
    	return view('admin.user.add');
    }

    /**
     * 用户的插入操作
     */
    public function postInsert(Request $request)
    {
    	//自己的判断
    	// $username = $request->input('username');
    	// //检测
    	// if(empty($username)){
    	// 	dd('用户名不能为空');
    	// }

    	// preg_match('/^\w{8,20}$/', $username, $temp);

    	// if(empty($temp)){
    	// 	dd('用户名格式不正确');
    	// }

    	//手动验证
    	$this->validate($request, [
	        'username' => 'required|unique:users|regex: /^\w{8,20}$/',
	        'password' => 'required|regex:/^\S{6,30}$/',
	        'repassword' => 'required|same:password',
	        'email'=>'required|regex:/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
	        'phone'=>'required|regex:/^1\d{10}$/'

	    ],[
	    	'username.required' => '用户名不能为空',
	    	'username.unique'=>'用户名已经存在',
	    	'username.regex' => '用户名格式不正确',
	    	'password.required'=>'密码不能为空',
	    	'password.regex' => '密码格式不正确',
	    	'repassword.required'=>'确认密码不能为空',
	    	'repassword.same'=>'两次的密码不一致',
	    	'email.required' => '邮箱不能为空',
	    	'email.regex'=>'邮箱的格式不正确',
	    	'phone.required'=>'手机号不能为空',
	    	'phone.regex'=>'手机号格式不正确'
	    ]);
	    $data = $request->only(['username','password','email','phone']);
    	//处理密码
    	$data['password'] = Hash::make($request->input('password'));
    	//生成随机的字符串
    	$data['token'] = str_random(50);
    	//上传图片
    	$profile = $this->getUploadFileName($request); 
    	$data['profile'] = $profile ? $profile : '';
    	//添加状态字段
    	$data['status'] = 0;
    	//插入数据库
    	if(DB::table('users')->insert($data)){
    		return redirect('/admin/user/index')->with('info','添加成功');
    	}else{
    		return back()->with('error','添加失败');
    	}
    }

    /**
     * 文件上传操作
     */
    private function getUploadFileName($request)
    {
		if($request->hasFile('profile')){
    		$name = time().rand(100000,999999);
			$suffix = $request->file('profile')->getClientOriginalExtension();
			$fileName = $name.'.'.$suffix;
    		$dir = './uploads/'.date('Ymd');
    		//进行上传
    		if($request->file('profile')->move($dir, $fileName)){
    			//写入当前图片的绝对路径
    			$profile = trim($dir.'/'.$fileName,'.');
    			return $profile;
    		}
    	}
    }

    /**
     * 用户的列表操作
     */
    public function getIndex(Request $request)
    {
    	//读取用户的信息
    	$users = DB::table('users')
    		->where(function($query)use($request){
    			//判断当前请求的keywords参数
    			$keywords = $request->input('keywords');
    			//检测
    			if(!empty($keywords)){
    				$query->where('username','like','%'.$keywords.'%');
    			}
    		})
            ->orderBy('id','asc')
    		->paginate($request->input('num',10));

    	return view('admin.user.index', [
    		'users'=>$users,
    		'title'=>'用户的列表页',
    		'request'=>$request
    		]);
    }

    /**
     * 用户的修改操作
     */
    public function getEdit(Request $request)
    {
    	//读取数据
    	$info = DB::table('users')->where('id',$request->input('id'))->first();
    	//判断
    	if(empty($info)){
    		abort(404);
    	}
    	//解析模板
    	return view('admin.user.edit', ['info'=>$info]);
    }

    /**
     * 用户的更新操作
     */
    public function postUpdate(Request $request)
    {
    	//更新
    	//手动验证
    	$this->validate($request, [
	        'username' => 'required|regex: /^\w{8,20}$/',
	        'email'=>'required|regex:/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/',
	        'phone'=>'required|regex:/^1\d{10}$/'

	    ],[
	    	'username.required' => '用户名不能为空',
	    	'username.unique'=>'用户名已经存在',
	    	'username.regex' => '用户名格式不正确',
	    	'email.required' => '邮箱不能为空',
	    	'email.regex'=>'邮箱的格式不正确',
	    	'phone.required'=>'手机号不能为空',
	    	'phone.regex'=>'手机号格式不正确'
	    ]);

	    //更新操作
	    $data = $request->except(['_token','id']);
	    //检测是否有文件上传
	    if($request->hasFile('profile')){
    		$profile = $this->getUploadFileName($request); 
    		$data['profile'] = $profile ? $profile : '';
    		//删除原来的图片
    		$this->deleteProfile($request->input('id'));
    	}
	    //更新操作
	    $res = DB::table('users')->where('id', $request->input('id'))->update($data);
	    if($res){
	    	return redirect('/admin/user/index')->with('info','更新成功');
	    }else{
	    	return back()->with('error','更新失败');
	    }
    }

    /**
     * 删除用户原来的头像
     */
    private function deleteProfile($id)
    {
    	//读取数据
    	$info = DB::table('users')->where('id',$id)->first();
    	//判断
    	if(empty($info)){
    		abort(404);
    	}
    	// '/uploads/20160711/1468208850116506.jpg';
    	//删除图片
    	//检测图片文件是否存在
    	$path = '.'.$info->profile;
    	if(file_exists($path)){
    		unlink($path);
    	}
    }

    /**
     * 用户的删除操作
     */
    public function getDelete(Request $request)
    {
    	//获取id
    	if(DB::table('users')->where('id',$request->input('id'))->delete()){
    		return back()->with('info', '删除成功');
    	}else{
    		return back()->with('error','删除失败');
    	}
    }
}
