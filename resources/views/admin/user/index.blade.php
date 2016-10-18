@extends('layout.admin')

@section('title',$title)

@section('content')
<div class="mws-panel grid_8">
	
  <div class="mws-panel-header">
    <span>
      <i class="icon-table"></i>用户列表</span>
  </div>
  <div class="mws-panel-body no-padding">
    <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
    	<form action="/admin/user/index">
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
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 207px;">用户名</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 195px;">邮箱</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 134px;">手机号</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 134px;">状态</th>
            <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 120px;">操作</th></tr>
        </thead>
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        @foreach($users as $k=>$v)
          <tr class="@if($k%2==0) even @else odd @endif">
            <td class=" sorting_1">{{$v->id}}</td>
            <td class=" ">{{$v->username}}</td>
            <td class=" ">{{$v->email}}</td>
            <td class=" ">{{$v->phone}}</td>
            <td class=" ">{{$v->status}}</td>
            <td class=" "><a class="btn btn-info" href="/admin/user/edit?id={{$v->id}}">修改</a><a class="btn btn-danger" href="/admin/user/delete?id={{$v->id}}">删除</a></td>
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
			{!! $users->appends($request->all())->render() !!}			
		</div>
      </div>
        
		
    </div>

  </div>
</div>
@endsection