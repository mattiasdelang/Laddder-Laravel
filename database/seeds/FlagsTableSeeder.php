<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FlagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('flags')->delete();

        DB::table('flags')->insert(
            [
                [
                    'id' => '1',
                    'userId' => '7',
                    'projectId' => '1',
                    'commentId' => '1',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '2',
                    'userId' => '3',
                    'projectId' => '5',
                    'commentId' => '3',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '3',
                    'userId' => '1',
                    'projectId' => '5',
                    'commentId' => '3',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '4',
                    'userId' => '2',
                    'projectId' => '7',
                    'commentId' => '4',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '5',
                    'userId' => '4',
                    'projectId' => '7',
                    'commentId' => '4',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],

            ]
        );
    }
}
