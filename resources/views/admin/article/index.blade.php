@extends('layout.admin')

@section('title',$title)

@section('content')
<div class="mws-panel grid_8">
	
  <div class="mws-panel-header">
    <span>
      <i class="icon-table"></i>文章列表</span>
  </div>
  <div class="mws-panel-body no-padding">
    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
    	<form action="/admin/article">
      	<div id="DataTables_Table_1_length" class="dataTables_length">
        <label>显示
          <select size="1" name="num" aria-controls="DataTables_Table_1">
            <option value="10" @if($request->input('num') == 10) selected="selected"  @endif >10</option>
            <option value="25" @if($request->input('num') == 25) selected="selected"  @endif>25</option>
            <option value="50" @if($request->input('num') == 50) selected="selected"  @endif>50</option>
            <option value="100" @if($request->input('num') == 100) selected="selected"  @endif>100</option>
          </select>条</label>
      	</div>
      	<div class="dataTables_filter" id="DataTables_Table_1_filter">
        <label>关键字:
          <input type="text" value="{{$request->input('keywords')}}" name="keywords" aria-controls="DataTables_Table_1"><button class="btn btn-primary">搜索</button></label>
      </div>
      </form>
      <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1" aria-describedby="DataTables_Table_1_info">
        <thead>
          <tr role="row">
            <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 80px;">ID</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 207px;">标题</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 195px;">分类</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 134px;">简介</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 134px;">状态</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 120px;">操作</th></tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        @foreach($articles as $k=>$v)
          <tr class="@if($k%2==0) even @else odd @endif">
            <td class=" sorting_1">{{$v->id}}</td>
            <td class=" ">{{$v->title}}</td>
            <td class=" ">{{$v->name}}</td>
            <td class=" ">{{$v->intro}}</td>
            <td class=" "><input cid="{{$v->id}}" class="ibutton" type="checkbox" @if($v->status) checked="checked" @endif></td>
            <td class=" "><a class="btn btn-info" href="/admin/article/{{$v->id}}/edit">修改</a><a class="btn btn-danger" href="/admin/article/delete/{{$v->id}}?">删除</a></td>
           </tr>
        @endforeach
        </tbody>
      </table>
      <style type="text/css">
			#pages{
				height:auto;
				overflow:hidden;
				margin-left:0px;
				padding-left:0px;
			}

			#pages li{
				float: left;
				height: 20px;
				padding: 0 10px;
				display: block;
				font-size: 12px;
				line-height: 20px;
				text-align: center;
				cursor: pointer;
				outline: none;
				background-color: #444444;
				color: #fff;
				text-decoration: none;
				border-right: 1px solid rgba(0, 0, 0, 0.5);
				border-left: 1px solid rgba(255, 255, 255, 0.15);
				-webkit-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
				-moz-box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
				box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.5), inset 0px 1px 0px rgba(255, 255, 255, 0.15);
			}
			#pages a{
				color:white;
			}
			#pages ul{
				height:auto;
				padding-left:0px;
				margin-left:3px;
			}
			#pages .active {
				float: left;
				height: 20px;
				padding: 0 10px;
				display: block;
				font-size: 12px;
				line-height: 20px;
				text-align: center;
				cursor: pointer;
				outline: none;
				background-color: #88a9eb;
				color:black;
			}
			#pages .disabled{
				color: #666666;
				cursor: default;
			}
      </style>
      <div style="padding-left:0px;margin-right:0px;" class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
      <div id="pages">
			{!! $articles->appends($request->all())->render() !!}			
		</div>
      </div>
        
		
    </div>

  </div>
</div>
@endsection

@section('css')
	<!-- Plugin Stylesheets first to ease overrides -->
	<link rel="stylesheet" type="text/css" href="/admins/plugins/colorpicker/colorpicker.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/custom-plugins/picklist/picklist.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/select2/select2.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/ibutton/jquery.ibutton.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/plugins/cleditor/jquery.cleditor.css" media="screen">

	<!-- Required Stylesheets -->
	<link rel="stylesheet" type="text/css" href="/admins/bootstrap/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/fonts/ptsans/stylesheet.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/fonts/icomoon/style.css" media="screen">

	<link rel="stylesheet" type="text/css" href="/admins/css/mws-style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/icons/icol16.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/icons/icol32.css" media="screen">

	<!-- Demo Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/css/demo.css" media="screen">

	<!-- jQuery-UI Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/jui/css/jquery.ui.all.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/jui/jquery-ui.custom.css" media="screen">

	<!-- Theme Stylesheet -->
	<link rel="stylesheet" type="text/css" href="/admins/css/mws-theme.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/admins/css/themer.css" media="screen">
@endsection

@section('js')
 	<script src="/admins/js/libs/jquery-1.8.3.min.js"></script>
    <script src="/admins/js/libs/jquery.mousewheel.min.js"></script>
    <script src="/admins/js/libs/jquery.placeholder.min.js"></script>
    <script src="/admins/custom-plugins/fileinput.js"></script>
    
    <!-- jQuery-UI Dependent Scripts -->
    <script src="/admins/jui/js/jquery-ui-1.9.2.min.js"></script>
    <script src="/admins/jui/jquery-ui.custom.min.js"></script>
    <script src="/admins/jui/js/jquery.ui.touch-punch.js"></script>

    <script src="/admins/jui/js/globalize/globalize.js"></script>
    <script src="/admins/jui/js/globalize/cultures/globalize.culture.en-US.js"></script>

    <!-- Plugin Scripts -->
    <script src="/admins/custom-plugins/picklist/picklist.min.js"></script>
    <script src="/admins/plugins/autosize/jquery.autosize.min.js"></script>
    <script src="/admins/plugins/select2/select2.min.js"></script>
    <script src="/admins/plugins/colorpicker/colorpicker-min.js"></script>
    <script src="/admins/plugins/validate/jquery.validate-min.js"></script>
    <script src="/admins/plugins/ibutton/jquery.ibutton.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.table.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.xhtml.min.js"></script>
    <script src="/admins/plugins/cleditor/jquery.cleditor.icon.min.js"></script>

    <!-- Core Script -->
    <script src="/admins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/admins/js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script src="/admins/js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script src="/admins/js/demo/demo.formelements.js"></script>

    <script type="text/javascript">
    //动态修改分类的状态
    $(function(){
		$('.ibutton-container').click(function(){
			//获取状态
			var status = $(this).find('input')[0].checked ? 1 : 0;
			var id = $(this).find('input').attr('cid');
			//发送
			$.get('/admin/article/ajax-update', {status: status, id: id}, function(data){
				if(data == '1'){
					alert('更新成功');
				}else{
					alert('更新失败');
				}
			});
		})
    })
    </script>
@endsection