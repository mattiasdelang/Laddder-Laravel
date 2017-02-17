<?php

namespace App\Providers;

use App\Activity;
use App\ProjectComment;
use App\ProjectLike;
use Illuminate\Support\Facades\Auth;
use App\UserAchievement;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->createLikeNotifications();
        $this->createCommentNotifications();
        $this->createAchievementNotifications();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function createLikeNotifications()
    {
        ProjectLike::created(function (ProjectLike $like) {

            $notification = new Activity();
            $notification->userId = $like->project->userId;

            $like->notification()->save($notification);

        });

        ProjectLike::deleted(function(ProjectLike $like) {
            $like->notification->delete();
        });

    }


    private function createCommentNotifications()
    {
        ProjectComment::created(function (ProjectComment $comment) {

            $notification = new Activity();
            $notification->userId = $comment->project->userId;

            $comment->notification()->save($notification);

        });

    }

    private function createAchievementNotifications()
    {
        UserAchievement::created(function (UserAchievement $achievement) {

            $notification = new Activity();
            $notification->userId = $achievement->userId;

            $achievement->notification()->save($notification);

        });

    }
}
