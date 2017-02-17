<?php

use Illuminate\Database\Seeder;

class UserRanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_ranks')->insert(
            [
                [
                    'name' => 'noob',
                    'xpreq' => 0,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'paint user',
                    'xpreq' => 1000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'paint.net user',
                    'xpreq' => 5000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'gimp baby',
                    'xpreq' => 15000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'gimp toddler',
                    'xpreq' => 25000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'gimp connaisseur',
                    'xpreq' => 45000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'photoshop baby',
                    'xpreq' => 75000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'photoshop toddler',
                    'xpreq' => 100000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'photoshop connaisseur',
                    'xpreq' => 200000,
                    'img' => 'notavailable.png',

                ],
                [
                    'name' => 'Design Master',
                    'xpreq' => 500000,
                    'img' => 'notavailable.png',

                ],


            ]
        );
    }
}
