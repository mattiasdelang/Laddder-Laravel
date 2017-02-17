<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('challenge_votes')->delete();

        DB::table('challenge_votes')->insert(
        	[
        	    [
        	    'id' => '1',
        		'userId' => '6',
        		'projectId' => '5',       
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),    	
        		],
                [
                'id' => '2',
                'userId' => '3',
                'projectId' => '5',       
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),     
                ],
                [
                'id' => '3',
                'userId' => '1',
                'projectId' => '5',       
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),      
                ],
                [
                'id' => '4',
                'userId' => '2',
                'projectId' => '7',       
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'id' => '5',
                'userId' => '4',
                'projectId' => '8',       
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),   
                ],

        	]
        );
    }
}