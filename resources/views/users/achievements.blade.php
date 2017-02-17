@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('style')
    <style>

        .achievements li#rank-{{$rankInfo->currentRank->id}}
         {
            color: #ffffff;
            background-color: orange;
         }

    </style>

@endsection

@section('content')
    <div class="container">
            <div class="achievements">
                <div class="row">
                    <div class="col-lg-12 explanation">
                        <h2>Explanation ranking</h2>
                        <p>It is your goal to climb our own laddder ranking system. The only reward you will achieve by climbing our ladder is a noticeable improvement in your design skills, and that is the best reward a designer could wish for.
                        there is no bad design or perfect design.
                        </p>
                        <p>
                            There is always room for improvement. So start with helping your fellow comrades by commenting on their work and give constructive feedback.

                        </p>
                    </div>
                </div>
                <div id="usernotifications" class="col-lg-3">
                    <h2>Laddder Ranking</h2>
                    <ul id="activitylog" class="list-group">
                        @foreach($ranks as $ranks)
                            <li class="list-group-item" id="rank-{{$ranks->id}}">
                                {{$ranks->id}}. <span>{{$ranks->name}}</span>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="col-lg-3 badges-show clearfix">
                    <h2>My achievements</h2>
                    <ul>
                        @if ($user->achievements->count() === 0 && $user->badges->count() === 0)
                            No achievements earned yet. Continue using our website to climb the ladder.
                        @elseif ($user->achievements->count() >= 1)


                            @foreach($user->achievements as $achievement)
                                <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="{{$achievement->name}}" src="/images/badges/{{$achievement->img}}" alt="{{$achievement->name}}">
                            @endforeach
                                @foreach($user->badges as $badge)
                                    <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="{{$badge->name}}" src="/images/badges/{{$badge->img}}" alt="{{$badge->name}}">
                                @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3 allbadges">
                    <div class="kindranks clearfix">
                        <h2>Different ranks</h2>
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Bronze" src="/images/badges/bronze.svg" alt="bronze">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Silver" src="/images/badges/silver.svg" alt="silver">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Gold" src="/images/badges/gold.svg" alt="gold">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Platinum" src="/images/badges/plat.svg" alt="platinum">
                    </div>

                    <div class="kindranks clearfix">
                        <h2>Different kinds</h2>
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Likes" src="/images/badges/likes_dark.svg" alt="likes">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Comments" src="/images/badges/comment_dark.svg" alt="comments">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Uploads" src="/images/badges/post_dark.svg" alt="uploads">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Invites" src="/images/badges/invite_dark.svg" alt="invites">
                        <img class="badgethumb" data-toggle="tooltip" data-placement="bottom" title="Login" src="/images/badges/login_dark.svg" alt="login">

                    </div>

                </div>

            </div>
        </div>




@endsection
