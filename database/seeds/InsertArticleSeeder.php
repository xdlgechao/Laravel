<?php

use Illuminate\Database\Seeder;

class InsertArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        for($i=0;$i<100;$i++){
        	$temp = [];
        	$temp['title'] = str_random(3);
        	$temp['intro'] = str_random(10);
        	$temp['content'] = str_random(20);
        	$temp['cate_id'] = rand(1,10);
        	$data[] = $temp;
        }
        DB::table('articles')->insert($data);
    }
}
