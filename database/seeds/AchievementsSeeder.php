<?php

use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('achievements')->insert(
            [
                [
                    'name' => '1000 Logins',
                    'img' => 'notavailable.png',
                    'xpreq' => 2000,
                    'xptype' => 'logins'
                ],
                [
                    'name' => '5000 logins',
                    'img' => 'notavailable.png',
                    'xpreq' => 10000,
                    'xptype' => 'logins'
                ],
                [
                    'name' => '10 000 logins',
                    'img' => 'notavailable.png',
                    'xpreq' => 20000,
                    'xptype' => 'logins'
                ],
                [
                    'name' => '10 likes on works',
                    'img' => 'like_bronze.svg',
                    'xpreq' => 500,
                    'xptype' => 'likes'
                ],
                [
                    'name' => '50 likes on works',
                    'img' => 'like_silver.svg',
                    'xpreq' => 2500,
                    'xptype' => 'likes'
                ],
                [
                    'name' => '100 likes on works',
                    'img' => 'like_gold.svg',
                    'xpreq' => 5000,
                    'xptype' => 'likes'
                ],
                [
                    'name' => '500 likes on works',
                    'img' => 'like_plat.svg',
                    'xpreq' => 50000,
                    'xptype' => 'likes'
                ],
                [
                    'name' => '10 comments on works',
                    'img' => 'comment_bronze.svg',
                    'xpreq' => 1500,
                    'xptype' => 'comments'
                ],
                [
                    'name' => '50 comments on works',
                    'img' => 'comment_silver.svg',
                    'xpreq' => 7500,
                    'xptype' => 'comments'
                ],
                [
                    'name' => '100 comments on works',
                    'img' => 'comment_gold.svg',
                    'xpreq' => 15000,
                    'xptype' => 'comments'
                ],
                [
                    'name' => '5000 comments on works',
                    'img' => 'comment_gold.svg',
                    'xpreq' => 150000,
                    'xptype' => 'comments'
                ],
                [
                    'name' => '5 total posts',
                    'img' => 'post_bronze.svg',
                    'xpreq' => 5000,
                    'xptype' => 'posts'
                ],
                [
                    'name' => '10 total posts',
                    'img' => 'post_silver.svg',
                    'xpreq' => 25000,
                    'xptype' => 'posts'
                ],
                [
                    'name' => '25 total posts',
                    'img' => 'post_gold.svg',
                    'xpreq' => 50000,
                    'xptype' => 'posts'
                ],
                [
                    'name' => '50 total posts',
                    'img' => 'post_plat.svg',
                    'xpreq' => 50000,
                    'xptype' => 'posts'
                ],
                [
                    'name' => '1 successful invite',
                    'img' => 'invite_bronze.svg',
                    'xpreq' => 1000,
                    'xptype' => 'invites'
                ],
                [
                    'name' => '5 successful invites',
                    'img' => 'invite_silver.svg',
                    'xpreq' => 5000,
                    'xptype' => 'invites'
                ],
                [
                    'name' => '10 successful invites',
                    'img' => 'invite_gold.svg',
                    'xpreq' => 10000,
                    'xptype' => 'invites'
                ],
                [
                    'name' => '15 successful invites',
                    'img' => 'invite_plat.svg',
                    'xpreq' => 15000,
                    'xptype' => 'invites'
                ]

            ]);
    }
}
