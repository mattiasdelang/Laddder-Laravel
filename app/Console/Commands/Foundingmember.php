<?php

namespace App\Console\Commands;

use App\Badge;
use App\User;
use App\UserExperience;
use Illuminate\Console\Command;

class Foundingmember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foundingmember';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give founding member badge to first 100 members.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $badge = Badge::whereName('Founding member')->firstOrFail();

        $users = User::orderBy('created_at')->take(100)->get();

        foreach($users as $user)
        {
            $user->badges()->attach($badge);
            UserExperience::addStats($user->userId, 'badges', 2000);
        }
        $this->info('Badges successfully added!');
    }
}
