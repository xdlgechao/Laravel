<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCateRequest;
use App\Http\Requests\UpdateCateRequest;
use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    //声明成员属性
    private $cates = [];

    /**
     * 快速获取当前表中分类信息
     */
    public static function getAllCates()
    {
        //获取分类信息
        $cates = DB::table('cates as a')
            ->select(DB::raw('a.*,b.name as names,concat(a.path,",",a.id) as paths'))
            ->leftJoin('cates as b','a.pid','=','b.id')
            ->orderBy('paths')
            ->get();
        //处理数据
        foreach ($cates as $key => $value) {
            //拆分数组
            $arr = explode(',', $value->path);
            $num  = count($arr)-1;
            $prefix = str_repeat('|-----', $num);
            $value -> name = $prefix. $value->name;
        }
        return $cates;
    }

    /**
     * 分类添加的页面显示
     */
    public function getAdd()
    {
        //读取当前分类表中所有 的数据
        $cates = DB::table('cates')->get();
        return view('admin.cate.add', ['cates'=>$cates]);
    }

    /**
     * 分类插入操作
     */
    public function postInsert(StoreCateRequest $request)
    {
        //获取参数
        $data = $request->except(['_token']);
        //判断当前的分类是否为顶级分类
        $data = $this->getData($data);
        //执行数据库插入
        if(DB::table('cates')->insert($data)){
            return redirect('/admin/cate/index')->with('info','添加成功');
        }else{
            return back()->with('error','添加失败');
        }
    }

    /**
     * 分类的列表显示
     */
    public function getIndex(Request $request)
    {
        //数据读取
        $cates = DB::table('cates as a')
            ->select(DB::raw('a.*,b.name as names,concat(a.path,",",a.id) as paths'))
            ->leftJoin('cates as b','a.pid','=','b.id')
            ->orderBy('paths')
            ->where(function($query)use($request){
                if(!empty($request)){
                    $query->where('a.name','like','%'.$request->input('keywords').'%');
                }
            })
            ->paginate($request->input('num', 10));

        //可以将数据库的查询结果转变成数组形式
        // $res = $cates->toArray();

        foreach ($cates as $key => $value) {
            //拆分数组
            $arr = explode(',', $value->path);
            $num  = count($arr)-1;
            $prefix = str_repeat('|-----', $num);
            $value -> name = $prefix. $value->name;
        }
        //模板解析
        return view('admin.cate.index', [
            'cates'=>$cates,
            'title'=>'分类列表',
            'request' => $request
            ]);
    }

    /**
     * ajax更新操作
     */
    public function getAjaxUpdate(Request $request)
    {
        //获取参数
        $data = $request->only(['status']);
        //更新
        $res = DB::table('cates')->where('id',$request->input('id'))->update($data);
        if($res){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }

    /**
     * 分类的修改操作
     */
    public function getEdit(Request $request)
    {
        //读取当前表中的信息
        $info = DB::table('cates')->where('id',$request->input('id'))->first();
        //判断
        if(empty($info)){
            abort(404);
        }
        //解析模板
        return view('admin.cate.edit', [
            'info'=>$info,
            'cates'=>DB::table('cates')->get()
            ]);
    }

    /**
     * 分类更新操作
     */
    public function postUpdate(UpdateCateRequest $request)
    {
        //获取参数
        $data = $request->only(['pid','name','status']);
        //
        $data = $this->getData($data);
        //更新动作
        if(DB::table('cates')->where('id',$request->input('id'))->update($data)){
            return redirect('/admin/cate/index')->with('info','更新成功');
        }else{
            return back()->with('error','更新失败');
        }
    }

    /**
     * 处理数据
     */
    private function getData($data)
    {
        //判断当前的分类是否为顶级分类
        if($data['pid'] == '0'){
            $data['path'] = '0';
        }else{
            //读取父级分类
            $p = DB::table('cates')->where('id',$data['pid'])->first();
            //拼接path路径
            $data['path'] = $p->path.','.$p->id;
        }
        return $data;
    }

    /**
     * 分类的删除
     */
    public function getDelete(Request $request)
    {
        //获取分类
        $id = $request->input('id');
        //获取path
        $info = DB::table('cates')->where('id',$id)->first();
        $prefix = $info->path.','.$info->id;
        //删除子类
        DB::table('cates')->where('path','like',$prefix.'%')->delete();
        //
        if(DB::table('cates')->where('id',$id)->delete()){
            return back()->with('info','删除成功');
        }else{
            return back()->with('error','删除失败');
        }
    }

    /**
     * 
     *  [
            [
                'id'=>1,
                'name'=>'男装',
                'subcate'=>[
                    [
                        'id'=>4,
                        'name'=>'西服',
                        'subcate'=>[
                            [
                                'id'=>7
                                'name'=>'韩版西服'
                            ],
                            [
                                'id'=>8,
                                'name'=>'美版西服'
                            ],
                            [
                                'id'=>9,
                                'name'=>'英伦西服'
                            ]
                        ]

                    ],
                    [
                        'id'=>5
                        'name'=>'皮鞋'
                    ]
                ]
            ],
            [
                'id'=>2,
                'name'=>'女装'
            ],
            [
                'id'=>3,
                'name'=>'童装'
            ]
     *
     *   ]
     */
    public function getCatesByPid($pid)
    {
        //获取父级分类
        $cates = DB::table('cates')->where('pid', $pid)->get();
        $res = [];
        foreach($cates as $k=>$v){
            $v->subcate=$this->getCatesByPid($v->id);
            $res[] = $v;
        }
        return $res;
    }

    public function getCates()
    {
        //声明成员属性
        if(!$this->cates){
            $this->cates = DB::table('cates')->get();
        }
        return $this->cates;
    }

    public function getCatesByPidArr($pid)
    {
        //获取顶级分类
        $cates = [];
        //获取所有的分类
        $allCates = $this->getCates();
        foreach($allCates as $k=>$v){
            if($v->pid == $pid){
                $cates[] = $v;
            }
        }

        $res = [];
        foreach($cates as $k=>$v){
            $v->subcate = $this->getCatesByPidArr($v->id);
            $res[] = $v;
        }
        return $res;
    }

    public function getTest()
    {
        //通过搜索数据库来实现
        // $cates = $this->getCatesByPid(0);

        //通过数据数组来实现
        $cates = $this->getCatesByPidArr(0);
        dd($cates);
    }

}
