<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Goods;
use App\Image;
use Config;
use DB;

class GoodsController extends Controller
{
    /**
     * 商品的添加页面的显示
     */
    public function getAdd()
    {
        //读取分类信息
        $cates = CateController::getAllCates();
        return view('admin.goods.add', [
            'title'=>'商品添加',
            'cates'=>$cates
            ]);
    }

    /**
     * 商品的插入操作
     */
    public function postInsert(Request $request)
    {
        $goods = new Goods;
        $goods->title = $request->input('title');
        $goods->cate_id = $request->input('cate_id');
        $goods->price = $request->input('price');
        $goods->content = $request->input('content');
        $goods->kucun = $request->input('kucun');
        $goods->color = $request->input('color');
        $goods->size = $request->input('size');

        //检测文件
        $images = [];
        if($request->hasFile('img')){
            foreach ($request->file('img') as $key => $value) {
                $dir = Config::get('app.upload_dir');
                $name = time().rand(100000,999999).'.'.$value->getClientOriginalExtension();
                $value->move($dir, $name);
                //修改图片的路径 
                $images[] = trim($dir.$name,'.');
            }
        }

        //插入主表
        DB::beginTransaction();
        if($goods->save()){
            // 插入附加表
                // foreach($images as $k=>$v){
                //     $img = new Image;
                //     $img->goods_id = $goods->id;
                //     $img->path = $v;
                //     $img->status = 1;
                //     $img->save();
                // }
            //模型就好比是简单的查询构造器
            if(!empty($images)){
                $data = [];
                foreach ($images as $key => $value) {
                    $temp = [];
                    $temp['goods_id'] = $goods->id;
                    $temp['path'] = $value;
                    $temp['status'] = 1;
                    $data[] = $temp;
                }
                if(Image::insert($data)){
                    DB::commit();
                    return redirect('admin/goods/index')->with('info','添加成功');
                }else{
                    DB::rollback();
                    return back()->with('error','添加失败');
                }
            }else{
                DB::commit();
                return redirect('admin/goods/index')->with('info','添加成功');
            }
        }else{
            DB::rollback();
            return back()->with('error','添加失败');
        }
    }

    /**
     * 分类显示
     */
    public function getIndex(Request $request)
    {
        $goods = Goods::where(function($query)use($request){
                //判断当前请求的keywords参数
                $keywords = $request->input('keywords');
                //检测
                if(!empty($keywords)){
                    $query->where('title','like','%'.$keywords.'%');
                }
            })
            ->orderBy('goods.id','desc')
            ->paginate($request->input('num',10));


        return view('admin.goods.index', [
            'goods'=>$goods,
            'title'=>'商品的列表页',
            'request'=>$request
            ]);
    }

    public function getEdit(Request $request)
    {
        //获取id
        $id = $request->input('id');
        //信息读取
        $info = Goods::findOrFail($id);

        //解析模板
        return view('admin.goods.edit', [
            'title'=>'商品的修改',
            'info' => $info,
            'cates'=> CateController::getAllCates()
            ]);
    }

    public function postUpdate(Request $request)
    {
        //获取参数
        $goods = Goods::find($request->input('id'));
        $goods->title = $request->input('title');
        $goods->cate_id = $request->input('cate_id');
        $goods->price = $request->input('price');
        $goods->content = $request->input('content');
        $goods->kucun = $request->input('kucun');
        $goods->color = $request->input('color');
        $goods->size = $request->input('size');

        //检测文件
        $images = [];
        if($request->hasFile('img')){
            foreach ($request->file('img') as $key => $value) {
                $dir = Config::get('app.upload_dir');
                $name = time().rand(100000,999999).'.'.$value->getClientOriginalExtension();
                $value->move($dir, $name);
                //修改图片的路径 
                $images[] = trim($dir.$name,'.');
            }
        }

        //插入主表
        DB::beginTransaction();
        if($goods->save()){
            // 插入附加表
                // foreach($images as $k=>$v){
                //     $img = new Image;
                //     $img->goods_id = $goods->id;
                //     $img->path = $v;
                //     $img->status = 1;
                //     $img->save();
                // }
            //模型就好比是简单的查询构造器
            if(!empty($images)){
                $data = [];
                foreach ($images as $key => $value) {
                    $temp = [];
                    $temp['goods_id'] = $goods->id;
                    $temp['path'] = $value;
                    $temp['status'] = 1;
                    $data[] = $temp;
                }
                if(Image::insert($data)){
                    DB::commit();
                    return redirect('admin/goods/index')->with('info','更新成功');
                }else{
                    DB::rollback();
                    return back()->with('error','更新失败');
                }
            }else{
                DB::commit();
                return redirect('admin/goods/index')->with('info','更新成功');
            }
        }else{
            DB::rollback();
            return back()->with('error','更新失败');
        }
    }

    public function getDelete(Request $request)
    {
        $goods = Goods::findOrFail($request->input('id'));
        //获取图片路径
        foreach ($goods->image as $key => $value) {
            $path  = $value->path;
            @unlink('.'.$path);
            //删除图片
            $value->delete();
        }

        //删除
        if($goods->delete()){
            return back()->with('info','删除成功');
        }else{
            return back()->with('error','删除失败');
        }

    }

}
