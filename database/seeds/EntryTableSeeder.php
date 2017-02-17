
<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EntryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('entries')->delete();

        DB::table('entries')->insert(
        	[
        	    [
                'id' => '1',
        	    'challengeId' => '1',
                'projectId' => '5',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),    	
        		],
                [
                'id' => '2',
                'challengeId' => '1',
                'projectId' => '6',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'id' => '3',
                'challengeId' => '1',
                'projectId' => '7',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'id' => '4',
                'challengeId' => '1',
                'projectId' => '8',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'id' => '5',
                'challengeId' => '2',
                'projectId' => '9',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],

        	]
        );
    }
}