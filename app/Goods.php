<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //声明商品和分类的关系  方法的名字一定要跟模型的名字保持一直
    public function cate()
    {
    	return $this->belongsTo('App\Cate');
    }

    public function image()
    {
    	return $this->hasMany('App\Image');
    }
}
