<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 
    	DB::table('users')->delete();

        DB::table('users')->insert(
        	[
        	    [
        		'userId' => '1',
	         	'username' => 'superuser',
	        	'email' => 'test@test.com',
	        	'password' => bcrypt('superuser'),
	        	'image' => 'usersample.png',
	        	'portfolio' => 'http://www.google.com',
	        	'twitter' => 'http://www.twitter.com',
	        	'facebook' => 'http://www.facebook.com',
	        	'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        		],
                [
                'userId' => '2',
                'username' => 'yannicknijs',
                'email' => 'yannick.nijs@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'userId' => '3',
                'username' => 'mattiasdelang',
                'email' => 'mattias.delang@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'userId' => '4',
                'username' => 'glennvanhaute',
                'email' => 'glenn.vanhaute@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'userId' => '5',
                'username' => 'bramdenyn',
                'email' => 'bram.denyn@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'userId' => '6',
                'username' => 'stijndhollander',
                'email' => 'stijn.dhollander@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'userId' => '7',
                'username' => 'pietervde',
                'email' => 'pieter.vanderelst@student.thomasmore.be',
                'password' => bcrypt('temptest'),
                'image' => 'usersample.png',
                'portfolio' => 'http://www.google.com',
                'twitter' => 'http://www.twitter.com',
                'facebook' => 'http://www.facebook.com',
                'opleiding' => 'Interactive Multimedia Design',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],

        	]
        );
    }
}
