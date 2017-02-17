<?php

use App\User;
use App\UserExperience;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $this->call(UserTableSeeder::class);
        $this->createUserExperienceData();
        $this->command->info('Users successfully seeded');
        $this->call(ProjectTableSeeder::class);
        $this->command->info('Projects successfully seeded');
        $this->call(AchievementsSeeder::class);
        $this->command->info('Achievements successfully seeded');
        $this->call(UserRanksSeeder::class);
        $this->command->info('UserRanks successfully seeded');
        $this->call(BadgesSeeder::class);
        $this->command->info('Badges successfully seeded');
        $this->call(UserApikeySeeder::class);
        $this->command->info('Apikeys successfully seeded');
        $this->call(ChallengeTableSeeder::class);
        $this->command->info('Challenges successfully seeded');
        $this->call(EntryTableSeeder::class);
        $this->command->info('Entries successfully seeded');
        $this->call(VoteTableSeeder::class);
        $this->command->info('Votes successfully seeded');
        $this->call(CommentsTableSeeder::class);
        $this->command->info('Comments successfully seeded');
        $this->call(FlagsTableSeeder::class);
        $this->command->info('Flags successfully seeded');

        Model::reguard();
    }

    private function createUserExperienceData()
    {
        foreach (User::all() as $user) {
            $achievementTypes = ['logins', 'likes', 'comments', 'posts', 'badges','invites'];

            foreach ($achievementTypes as $typeName) {
                $data = array('userId' => $user->userId, 'type' => $typeName, 'xp' => 0);
                UserExperience::create($data);
            }
        }

    }
}
