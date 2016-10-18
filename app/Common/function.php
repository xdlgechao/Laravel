<?php 
	
	/**
	 * 通过id获取分类名称
	 */
	function getCateNameById($id)
	{
		//判断
		if($id == 0){
			return '顶级分类';
		}
		//查询数据
		$res = DB::table('cates')->where('id',$id)->first();
		return $res->name;
	}




 ?>