<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Config;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //读取文章的信息
        $articles = DB::table('articles')
            ->where(function($query)use($request){
                //判断当前请求的keywords参数
                $keywords = $request->input('keywords');
                //检测
                if(!empty($keywords)){
                    $query->where('title','like','%'.$keywords.'%');
                }
            })
            ->leftJoin('cates','cates.id','=','articles.cate_id')
            ->orderBy('articles.id','desc')
            ->paginate($request->input('num',10));

        return view('admin.article.index', [
            'articles'=>$articles,
            'title'=>'文章的列表页',
            'request'=>$request
            ]);
    }


    /**
     * ajax更新操作
     */
    public function ajaxUpdate(Request $request)
    {
        if(DB::table('articles')
            ->where('id',$request->input('id'))
            ->update($request->only(['status']))){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //读取分类信息
        $cates = CateController::getAllCates();
        return view('admin.article.add', ['cates'=>$cates]);
    }

    /**
     * 文章添加
     */
    public function store(InsertArticleRequest $request)
    {
        //获取参数
        $data = $request->except(['_token']);
        //文件上传操作
        if($request->hasFile('img')){
            $dir = Config::get('app.upload_dir');
            $name = Config::get('app.upload_img_name').'.'.$request->file('img')->getClientOriginalExtension();
            $request->file('img')->move($dir, $name);
            //修改图片的路径 
            $data['img'] = trim($dir.$name,'.');
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        //插入
        $res = DB::table('articles')->insert($data);
        //检测
        if($res){
            return redirect('/admin/article')->with('info', '添加成功');
        }else{
            return back()->with('error','添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo '显示文章';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //读取数据显示模板
        $info = DB::table('articles')->where('id', $id)->first();
        //解析模板
        return view('admin.article.edit', [
            'info' => $info,
            'title'=>'文章的修改',
            'cates'=> CateController::getAllCates()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_token','_method','id']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        if(DB::table('articles')->where('id',$id)->update($data)){
            return redirect('/admin/article')->with('info','修改成功');
        }else{
            return back()->with('error','修改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //删除
        if(DB::table('articles')->where('id', $id)->delete()){
            return back()->with('info','删除成功');
        }else{
            return back()->with('error','删除失败');
        }
    }
}
