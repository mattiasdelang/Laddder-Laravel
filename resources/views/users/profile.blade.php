@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')


    <div id="profile-page" class="container">

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <h1> 
                    @if(Auth::id() == $profile->userId) Hello @endif {{ $profile->username }} 

                        @if(Auth::id() != $user->userId) 
                        @if (Auth::user()->isFollowing($user))
                            <small class="pull-right text">You are following {{ $user->username }}</small>
                        @else
                            <a class="btn btn-default btnLaddderOrange pull-right" href="{{ route('follower.add', ['username' => $user->username]) }}" class="btn btn-primary">Follow</a>
                        @endif

                    @endif
                    </h1>
                </div>
            </div>
            <div id="usercred" class="row">
                <div class="col-md-6">
                    <h2>Profile info</h2>




                    <img class="userimgthumb" src="/profilepics/{{ $profile->image }}" alt="Profile picture">
                    <ul class="userinfo">
                        <li>
                            <a href="http://{{ $profile->portfolio }}">{{ $profile->portfolio }}</a>
                        </li>
                        <li>
                             <a href="http://twitter.com/{{ $profile->twitter }}">Twitter</a>
                        </li>
                        <li>
                            <a href="http://facebook.com/{{ $profile->facebook }}">Facebook</a>
                        </li>
                        <li>
                            <p>Opleiding: {{ $profile->opleiding }}</p>
                        </li>
                    </ul>
                    @if(Auth::id() == $profile->userId)
                    <div class="buttons-profile">
                        <a class="btn btn-default btnLaddderOrange" href="/user/edit-profile">Edit Profile</a>
                        <span class="ctaInvitefriends"><a href="/referfriend">Invite Friends</a></span>
                    </div>
                    @endif

                    <div class="col-md-6 badges">
                        <h2>Badges</h2>
                        @if ($user->achievements->count() === 0)
                            This user has not yet earned any badges.
                        @elseif ($user->achievements->count() >= 1)

                        @foreach($user->achievements as $achievement)
                            <img class="badgethumb" src="/images/badges/{{$achievement->img}}" alt="{{$achievement->name}}-badge"/>
                        @endforeach
                        @endif

                    </div>

                </div>

                <h2>Works</h2>

            <div class="row">
                <h2>My work</h2>

            @foreach($projecten as $project)
                    <div class="col-sm-6 col-lg-3 project">
                        <div class="thumbnail">
                            <img src="/project_images/{{$project->image}}" alt="{{$project->image}}"/>
                            <div class="caption">
                                <h3><a href="/projects/{{$project->projectId}}">{{$project->title}}</a></h3>

                            </div>
                        </div>

                    </div>
            @endforeach
                <div class="pagination">
                    {!! $projecten->render() !!}

                </div>

            </div>

            <div class="row">

            </div>
            
            @if(Auth::id() == $profile->userId)
            <div class="row">
                <div id="usernotifications" class="col-md-6">
                    <h2>Notifications</h2>
                    <ul id="activitylog" class="list-group">
                        @foreach($activities as $activity)
                            @if($activity->source_type == "App\\ProjectLike")

                                <li class="list-group-item">
                                    <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                    <a href="/projects/{{$activity->source->project->projectId}}" >
                                        <strong><em>{{ $activity->source->user->username }}</em></strong> has liked your work,
                                        {{ $activity->source->project->title }},
                                        <cite>&nbsp;{{\Carbon\Carbon::parse($activity->created_at)->diffForHumans() }} </cite>
                                    </a>
                                </li>

                            @elseif($activity->source_type == "App\\ProjectComment")

                                <li class="list-group-item">
                                    <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                    <a href="/projects/{{$activity->source->project->projectId}}" >
                                        <strong><em>{{ $activity->source->user->username }}</em></strong> has commented on your work,
                                        {{ $activity->source->project->title }},
                                        <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
                                    </a>
                                </li>

                            @elseif($activity->source_type == "App\\UserAchievement")

                                <li class="list-group-item">
                                    <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                    <a href="/achievements" >
                                        <strong><em>{{ $activity->source->achievement->name }}</em></strong> has been reached,
                                        <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
                                    </a>
                                </li>

                            @endif
                        @endforeach

                    </ul>

                    <a class="btn btn-default btnLaddderOrange" href="/activity">Check notifications</a>
                </div>


                <div class="col-md-6">
                    <div id="userfavoriteslog">
                        <h2>My favorites</h2>
                        <ul id="ulfavoriteLog" class="list-group">
                            
                        </ul>
                        <a class="btn btn-default btnLaddderOrange" href="/myLikes">Check favorites</a>
                    </div>
                </div>  

            </div>
            @endif()

         
        </div>    

    </div>
@endsection