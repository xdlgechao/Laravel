<?php

use Illuminate\Database\Seeder;

class Goods extends Seeder
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
        for($i=0;$i<50;$i++){
        	$temp = [];
        	$temp['title'] = str_random(3);
        	$temp['content'] = str_random(20);
        	$temp['cate_id'] = rand(1,10);
        	$temp['price'] = rand(1,1000);
        	$temp['kucun'] = rand(1,20);
        	$temp['color'] = "红色,绿色,白色";
        	$temp['size'] = "L,XL,XXL";
        	$temp['status'] = "1";
        	$data[] = $temp;
        }
        DB::table('goods')->insert($data);
    }
}
