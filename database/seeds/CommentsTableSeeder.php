<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('comments')->delete();

        DB::table('comments')->insert(
            [
                [
                    'id' => '1',
                    'userId' => '6',
                    'projectId' => '1',
                    'comment' => 'This is a comment to a work. Hail Lord Helix!',
                    'flagCount' => '1',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '2',
                    'userId' => '3',
                    'projectId' => '5',
                    'comment' => 'Hello yes this is comment',
                    'flagCount' => '',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '3',
                    'userId' => '1',
                    'projectId' => '5',
                    'comment' => 'This sucks. I hate you.',
                    'flagCount' => '2',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '4',
                    'userId' => '2',
                    'projectId' => '7',
                    'comment' => 'Trololololololol',
                    'flagCount' => '2',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => '5',
                    'userId' => '4',
                    'projectId' => '8',
                    'comment' => 'Well this is nice',
                    'flagCount' => '',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],

            ]
        );

    }
}
