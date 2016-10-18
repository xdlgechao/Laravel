<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Image;

class ImageController extends Controller
{
    public function getDelete(Request $request)
    {
        //获取id
        $id = $request->input('id');
        $image = Image::findOrFail($id);
        //删除当前这条数据
        if($image->delete()) {
            echo 1;die;
        }else{
            echo 0;die;
        }
    }
}
