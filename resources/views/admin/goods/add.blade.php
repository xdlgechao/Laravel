@extends('layout.admin')

@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>商品添加</span>
    </div>
    <div class="mws-panel-body no-padding">
        @if (count($errors) > 0)
        <div class="mws-form-message error">
            错误信息
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    	<form action="/admin/goods/insert" method="post" class="mws-form" enctype="multipart/form-data">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">商品标题</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" value="{{old('title')}}" name="title">
    				</div>
    			</div>

                <div class="mws-form-row">
                    <label class="mws-form-label">商品的主图</label>
                    <div class="mws-form-item" style="width:400px">
                        <input type="file" class="small" name="img[]" multiple>
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">分类id</label>
                    <div class="mws-form-item">
                        <select class="small" name="cate_id">
                            <option value="0">请选择</option>
                            @foreach($cates as $k=>$v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

    			<div class="mws-form-row">
                    <label class="mws-form-label">价格</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" value="{{old('price')}}" name="price">
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">颜色</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" value="{{old('color')}}" name="color">
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">尺码</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" value="{{old('size')}}" name="size">
                    </div>
                </div>
                <div class="mws-form-row">
                    <label class="mws-form-label">库存</label>
                    <div class="mws-form-item">
                        <input type="text" class="small" value="{{old('kucun')}}" name="kucun">
                    </div>
                </div>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.config.js"></script>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.all.min.js"> </script>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/lang/zh-cn/zh-cn.js"></script>
                            

                <div class="mws-form-row">
                    <label class="mws-form-label">商品的内容</label>
                    <div class="mws-form-item">
                        <script name="content" id="editor" type="text/plain" style="width:800px;height:400px;"></script>
                    </div>
                </div>
                <script type="text/javascript">
                    var ue = UE.getEditor('editor', {toolbars: [
                        ['fullscreen', 'source', 'undo', 'redo', 'bold','simpleupload']
                    ]});
                </script>
    		</div>
    		<div class="mws-button-row">
    			{{csrf_field()}}
    			<input type="submit" class="btn btn-danger" value="添加">
    			<input type="reset" class="btn " value="重置">
    		</div>
    	</form>
    </div>    	
</div>
@endsection