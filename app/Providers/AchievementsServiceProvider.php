<?php

namespace App\Providers;

use App\Achievement;
use App\UserAchievement;
use App\UserExperience;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Session;

class AchievementsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Event::listen('auth.logout', function ($user) {
            Session::forget('RankInfo');
        });

        \Event::listen('auth.login', function ($user) {
            $this->updateSession($user);
        });

        \Event::listen('achievement.updated', function ($updatedUser, $achievementType) {
            $updatedUserId = $updatedUser;

            $this->getNextAchievement($updatedUser, $achievementType);

            // Check if we are talking about the logged in user.
            $user = \Auth::user();
            if (!$user || $user->userId !== $updatedUserId) {
                return;
            }

            $this->updateSession($user);
        });

        // Add initial achievements for newly created user.
        User::created(function ($user) {

            $achievementTypes = ['logins', 'likes', 'comments', 'posts','badges','invites'];

            foreach ($achievementTypes as $typeName) {
                $data = array('userId' => $user->userId, 'type' => $typeName, 'xp' => 0);
                UserExperience::create($data);
            }

            $apikey = str_random(32);

            DB::table('user_apikey')->insert(
                array('userId' => $user->userId, 'key' => $apikey,'calls'=>0)
            );


        });

        // Enable {{ $rankInfo }} on _all_ view pages.
        view()->composer('*', function($view) {
            if(!\Auth::check())
                return;

            $rankInfo = \App::make('RankInfo');
            $view->with('rankInfo', $rankInfo);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \App::singleton('RankInfo', 'stdClass');
    }

    /**
     * @param User $user
     * @return int
     */
    private function getCurrentExperience(User $user)
    {

        $row = DB::table('user_experience')
            ->select(DB::raw('sum(xp) as totalxp'))
            ->where('userId', $user->userId)
            ->first();

        $totalExp = is_null($row->totalxp) ? 0 : $row->totalxp;
        return $totalExp;
    }

    private function getNextRank($currentExp)
    {
        $row = DB::table('user_ranks')
                ->where('xpreq','>',$currentExp)
                ->orderBy('xpreq','asc')
                ->first();

        return $row;
    }

    /**
     * @param int $currentExp
     * @return string
     *
     */
    private function getUserRankForExperience($currentExp)
    {
        $row = DB::table('user_ranks')
            ->select('id','name','img')
            ->where('xpreq', '<=', $currentExp)
            ->orderBy('xpreq', 'desc')
            ->first();

        return $row;
    }

    /**
     * @param User $user
     * @param string $type
     * @return null|Achievement
     */
    private function getNextAchievement($user, $type)
    {
        $userId = $user;

        $outcome = \DB::table('achievements')
            ->select('achievements.id')
            ->join('user_experience', 'user_experience.type', '=', 'achievements.xptype')
            ->leftJoin('user_achievements', 'user_achievements.achievementId', '=', 'achievements.id')
            ->where('user_experience.userId', $userId)
            ->where('achievements.xptype', $type)
            ->whereRaw('achievements.xpreq <= user_experience.xp')
            ->whereNull('user_achievements.id')
            ->orderby('achievements.xpreq', 'desc')
            ->take(1)
            ->first();

        //Outcome, id of the achievement he has to receive, in this case 2

        if (!empty($outcome)) {

            $achievement = new UserAchievement();
            $achievement->userId = $userId;
            $achievement->achievementId = $outcome->id;
            $achievement->save();

        }

    }

    /**
     * @param $user
     */
    private function updateSession(User $user)
    {
        $currentExp = $this->getCurrentExperience($user);
        $userRank = $this->getUserRankForExperience($currentExp);
        $nextRank = $this->getNextRank($currentExp);

        $nextRank->percentage = ceil($currentExp / $nextRank->xpreq * 100);

        $rankInfo = \App::make('RankInfo');
        $rankInfo->currentExp = $currentExp;
        $rankInfo->currentRank = (array)$userRank;
        $rankInfo->nextRank = (array)$nextRank;

        $arr = (array)$rankInfo;

        // update Session
        Session::set('RankInfo', json_encode($arr));
    }
}
