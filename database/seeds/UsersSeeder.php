<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
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
        	$temp['username'] = str_random(3);
        	$temp['password'] = Hash::make('iloveyou');
        	$temp['email'] = str_random(4).'@qq.com';
        	$phone = '';
        	for($j=0;$j<11;$j++){
        		$phone .= rand(1,9);
        	}
        	$temp['phone'] = $phone;
        	$temp['token'] = str_random(50);
        	$temp['status']=0;
        	$data[] = $temp;
        }
        DB::table('users')->insert($data);
    }
}
