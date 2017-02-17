<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChallengeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('challenges')->delete();

        DB::table('challenges')->insert(
        	[
        	    [
        	    'challengeId' => '1',
        		'title' => 'Best Signup Form',
        		'description' => 'In this month\'/s challenge we challenge you to design the best Signup form. Pay attention to detail, UX, UI. Let the battle commence!', 
        		'banner' => 'testbanner.jpg',
                'startdate' => '2015/10/01',
                'enddate' => '2015/10/31',           
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),    	
        		],
                [
                'challengeId' => '2',
                'title' => 'Best Personal Branding',
                'description' => 'In this month\'/s challenge we challenge you to show your personal branding. Pay attention to detail, UX, UI. Let the battle commence!', 
                'banner' => 'testbanner.jpg',
                'startdate' => '2015/09/01',
                'enddate' => '2015/09/30',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'challengeId' => '3',
                'title' => 'Best Lettering',
                'description' => 'In this month\'/s challenge we challenge you to draw some awesome Lettering. Pay attention to detail, UX, UI. Let the battle commence!', 
                'banner' => 'testbanner.jpg',
                'startdate' => '2015/11/01',
                'enddate' => '2015/11/30',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'challengeId' => '4',
                'title' => 'Wallpaper Contest',
                'description' => 'In this month\'/s challenge we challenge you to design the best Wallpaper. Pay attention to detail, UX, UI. Let the battle commence!', 
                'banner' => 'testbanner.jpg',
                'startdate' => '2015/12/01',
                'enddate' => '2015/12/31',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'challengeId' => '5',
                'title' => 'Design The New IMD Logo',
                'description' => 'In this month\'/s challenge we challenge you to design the new IMD logo. Pay attention to detail, UX, UI. Let the battle commence!', 
                'banner' => 'testbanner.jpg',
                'startdate' => '2016/01/01',
                'enddate' => '2016/01/31',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],

        	]
        );
    }
}