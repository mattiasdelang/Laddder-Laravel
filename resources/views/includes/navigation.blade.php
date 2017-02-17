    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>
        $("document").ready(function () {
            $(".notiurl").click(function (e) {
                $.ajax({
                    type: "POST",
                    url: "../seennoti",
                    success: function (data) {
                        $(".glyphicon-bell").removeClass("newact");
                    }
                }, "json");
            });
        });
    </script>

<header>
    <nav class="navbar navbar-inverse navbar-static-top page-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/homepage">
                    <img id="navlogo" alt="laddder" src="/images/logo.svg">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/homepage">Home</a></li>
                    <li><a href="/challenge/4">Challenges</a></li>
                    <li><a href="/create">Add work</a></li>
                    <li><a href="/followers">Followers</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">

                    @if(!Auth::check())
                        <li><a href="/login">Login</a></li>
                    @endif

                    @if(Auth::check())

                        <li class="dropdown dropnav">
                            <a href="#" class="usercreds dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <img class="navuserthumb" src="/profilepics/{{ Auth::user()->image}}" alt="" title="">
                                <span id="navusername">{{ Auth::user()->username }}</span>
                                <span class="glyphicon glyphicon-menu-down"></span>
                            </a>
                            <ul class="dropdown-menu">

                                <li><a href="{{ URL::to('/user/profile/' . Auth::user()->userId) }}">My profile</a></li>
                                <li><a href="/apikey">Dev Docs</a></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    @endif

                    @if(Auth::check())
                            <li class="dropdown dropnoti">
                            <a href="/activity" class="notiurl dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-bell notification no {{$newactivity}}"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($activities as $activity)

                                     @if($activity->source_type == "App\\ProjectLike")

                                         <li class="list-group-item iets{{$activity->seen}}">
                                             <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                             <a href="/projects/{{$activity->source->project->projectId}}" >
                                                 <strong><em>{{ $activity->source->user->username }}</em></strong> has liked your work,
                                                 {{ $activity->source->project->title }},
                                                 <cite>&nbsp;{{\Carbon\Carbon::parse($activity->created_at)->diffForHumans() }} </cite>
                                             </a>
                                         </li>

                                     @elseif($activity->source_type == "App\\ProjectComment")

                                         <li class="list-group-item iets{{$activity->seen}}">
                                             <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                             <a href="/projects/{{$activity->source->project->projectId}}" >
                                                 <strong><em>{{ $activity->source->user->username }}</em></strong> has commented on your work,
                                                 {{ $activity->source->project->title }},
                                                 <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
                                             </a>
                                         </li>
                                     @elseif($activity->source_type == "App\\UserAchievement")

                                         <li class="list-group-item iets{{$activity->seen}}">
                                             <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
                                             <a href="/achievements" >
                                                 <strong><em>{{ $activity->source->achievement->name }}</em></strong> has been reached,
                                                 <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
                                             </a>
                                         </li>

                                     @endif

                                @endforeach
                                <li><a href="/activity" class="showmorenoti">Show all activities</a></li>
                            </ul>
                            </li>
                    @endif

                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        @if(Auth::check())
            <a href="/achievements">
                <div id="outer_bar">
                    <p><span>Rank:</span> {{$rankInfo->currentRank->name}} <span>&nbsp;Exp:</span> {{$rankInfo->currentExp}}
                        /{{$rankInfo->nextRank->xpreq}}</p>
                    <div id="inner_bar" style="width:{{$rankInfo->nextRank->percentage}}%;"></div>
                </div>
            </a>
        @endif
    </nav>
</header>


