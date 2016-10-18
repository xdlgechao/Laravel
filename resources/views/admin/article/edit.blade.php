@extends('layout.admin')

@section('content')
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span>文章修改</span>
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
    	<form action="/admin/article/{{$info->id}}" method="post" class="mws-form" enctype="multipart/form-data">
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label class="mws-form-label">文章标题</label>
    				<div class="mws-form-item">
    					<input type="text" class="small" name="title" value="{{$info->title}}">
    				</div>
    			</div>

                <div class="mws-form-row">
                    <label class="mws-form-label">文章的主图</label>
                    <div class="mws-form-item" style="width:400px">
                        <img src="{{$info->img}}"  width="100" alt="">
                        <input type="file" class="small" name="img">
                    </div>
                </div>

                <div class="mws-form-row">
                    <label class="mws-form-label">分类id</label>
                    <div class="mws-form-item">
                        <select class="small" name="cate_id">
                            <option value="0">请选择</option>
                            @foreach($cates as $k=>$v)
                            <option @if($info->cate_id == $v->id) selected="selected" @endif value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

    			<div class="mws-form-row">
                    <label class="mws-form-label">摘要</label>
                    <div class="mws-form-item">
                        <textarea name="intro" class="small" id="" rows="10">{{$info->intro}}</textarea>
                    </div>
                </div>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.config.js"></script>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/ueditor.all.min.js"> </script>
                <script type="text/javascript" charset="utf-8" src="/admins/ueditor/lang/zh-cn/zh-cn.js"></script>

                <div class="mws-form-row">
                    <label class="mws-form-label">文章的内容</label>
                    <div class="mws-form-item">
                        <script name="content" id="editor" type="text/plain" style="width:800px;height:400px;">{{$info->content}}</script>
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
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="id" value="{{$info->id}}">
    			<input type="submit" class="btn btn-danger" value="修改">
    			<input type="reset" class="btn " value="重置">
    		</div>
    	</form>
    </div>    	
</div>
@endsection