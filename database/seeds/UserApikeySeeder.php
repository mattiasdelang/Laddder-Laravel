<?php

use Illuminate\Database\Seeder;

class UserApikeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_apikey')->insert(
            [
                [
                    'userId' => 1,
                    'key' => '6faoU2Ca3t8HGXSgZbDiVghr8A4ZEEm9',
                    'calls' => 0,

                ],
                [
                    'userId' => 2,
                    'key' => 'JXouVPmGfPbpC0U7Lsswxlx5o09k4iIh',
                    'calls' => 0,

                ],
                [
                    'userId' => 3,
                    'key' => 'REsWiKHzW4P8Ay06hg7EO4jO3VsBPYDq',
                    'calls' => 0,

                ],
                [
                    'userId' => 4,
                    'key' => 'OoqLzlZyPigTlcDo2cXChy9ukTzeesSl',
                    'calls' => 0,

                ],
                [
                    'userId' => 5,
                    'key' => 'RONRvWLSn2W5IJ9nBZkikxkLxZWfagLs',
                    'calls' => 0,

                ],
                [
                    'userId' => 6,
                    'key' => 'qLcJHmbBgHiy4edajov1Y8UGpRBrSJfS',
                    'calls' => 0,

                ],
                [
                    'userId' => 7,
                    'key' => '4g2vMZylWU5OR0l7X2V56sgOvmMEonVY',
                    'calls' => 0,

                ]
        ]);
    }
}
