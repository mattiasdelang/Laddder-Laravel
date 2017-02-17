
<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('project_images')->delete();

        DB::table('project_images')->insert(

            [
                [
                'projectId' => '1',
                'userId' => '2',
                'title' => 'Fancy Branding',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/branding.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),       
                ],
                [
                'projectId' => '2',
                'userId' => '3',
                'title' => 'Best Friends',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/bestfriends.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '3',
                'userId' => '4',
                'title' => 'Flatweb Recipes',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/flatweb.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '4',
                'userId' => '5',
                'title' => 'Iconset',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/iconset.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '5',
                'userId' => '6',
                'title' => 'Stay Fresh!',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/lettering.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '3',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '6',
                'userId' => '7',
                'title' => 'I love fridays',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/lettering2.png',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '7',
                'userId' => '2',
                'title' => 'Logo Minimal Force',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/logodesign.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '8',
                'userId' => '3',
                'title' => 'Logo Occult',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/logodesign2.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '9',
                'userId' => '4',
                'title' => 'New Portfolio',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/portfolio.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '10',
                'userId' => '5',
                'title' => 'Self-Portrait',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/portrait.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '11',
                'userId' => '6',
                'title' => 'Vcard Design',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/vcard.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                'projectId' => '12',
                'userId' => '7',
                'title' => 'Website Mockup',
                'description' => 'Dit is mijn nieuwste werk', 
                'image' => 'tmp/webdesign.jpg',
                'tags' => 'Design, Vectors, Test',
                'voteCount' => '0',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],

            ]
        );
    }
}
