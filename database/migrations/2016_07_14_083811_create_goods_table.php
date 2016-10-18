<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键自增id');
            $table->string('title')->comment('商品的名称');
            $table->string('cate_id')->comment('商品的分类id');
            $table->decimal('price',10,2)->comment('商品的价格');
            $table->text('content')->comment('商品的内容');
            $table->string('color')->comment('商品的颜色  红色,绿色,粉色');
            $table->string('size')->comment('商品的尺码  L,XXL,XXXL');
            $table->integer('kucun')->comment('商品的库存');
            $table->tinyInteger('status')->comment('状态 0为下架 1为上架')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('goods');
    }
}
