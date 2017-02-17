<?php

use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges')->insert(
            [
                [
                    'name' => 'Founding member',
                    'img' => 'notavailable.png'
                ]
            ]);
    }
}
