<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->comment('主键自增id');
            $table->string('title')->comment('文章的标题');
            $table->text('intro')->comment('文章的摘要');
            $table->text('content')->comment('文章的内容');
            $table->integer('cate_id')->comment('文章的分类id');
            $table->string('img')->comment('文章的主图');
            $table->string('thumb')->comment('文章的缩略图');
            $table->tinyInteger('status')->default(1)->comment('文章的状态');
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
        Schema::drop('articles');
    }
}
