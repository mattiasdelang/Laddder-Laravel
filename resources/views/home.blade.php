@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection


@section('content')

         <div id="pageheader">
            <h1>Homepage</h1>
        </div>


 <div id="homepage" class="container-fluid">
    <div class="content">

        <div class="row">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <div class="col-lg-3 ilters">
                <a href="/create" id="btnAddWork" class="">Add work</a>


                <form id="search" action="/search" class="form" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="group">
                        <input type="text"name ="search" id="search" class="form-control" placeholder="Search">
                    </div>
                </form>
                <h2>Filters</h2>
                <?php $i = 0;?>
                @foreach ($tagList as $link)
                    <p><a href="/projects/tag/{{$link}}"  class="">{{$link}}</a></p>
                    @if (++$i == 5)
                        <?php break; ?>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-sm-12 challenge">
                        <h2>Challenges</h2>


                            <a id="ctaEnterChallenge" href="/challenge/{{$data[0]->challengeId}}"> ENTER CHALLENGE </a>

                            <h4>Last month's contest winner!</h4>

                            @if (count($winnerdata) > 0)
                                <div class="thumbnail">
                                    <img src="/project_images/{{$winnerdata[0]->image}}"/>
                                    <div class="caption">
                                        <a href="/projects/{{$winnerdata[0]->projectId}}"><h3>{{$winnerdata[0]->title}}</h3></a>
                                        <p>By <a href="/user/profile/{{$winnerdata[0]->userId}}">{{$winnername[0]->username}}</a></p>
                                    </div>
                                </div>
                            @else
                                <p>There are no winners this month!</p>
                            @endif
                    </div>
                </div>
            </div>



            
            <div class="col-lg-9 projects">

                <div class="projects-container">
                    @foreach($projecten as $project)
                        <div class="col-sm-6 col-lg-3 project">
                            <a href="/projects/{{$project->projectId}}"><div class="thumbnail">
                                <a href="/projects/{{$project->projectId}}"><img src="/project_images/{{$project->image}}" alt="{{$project->image}}"/></a>
                                <div class="caption">
                                    <h3><a href="/projects/{{$project->projectId}}">{{$project->title}}</a></h3>
                                    <p id="captionUsername">- <a href="/user/profile/{{$project->userId}}">{{$project->username}}</a></p>
                                </div>
                            </div></a>
                        </div>
                    @endforeach
                        @foreach($ads as $ad)
                            <div class="col-sm-6 col-lg-3 project">
                                <div class="thumbnail">
                                    <a href="http://{{$ad->link}}"><img src="/ad_images/{{$ad->image}}" alt="{{$ad->image}}"/></a>
                                    <div class="adcaption">
                                        <p>Advertisement:</p>
                                        <h3><a href="http://{{$ad->link}}">{{$ad->name}}</a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @for ($i = 0; $i < (3 - count($ads)); $i++)

                            <div class="col-sm-6 col-lg-3 project">
                                <div class="thumbnail">
                                    <a href="/ads/create"><img class="slot" src="/images/adslot.png" alt="Free ad slot"/></a>
                                </div>
                            </div>
                        @endfor
                </div>

                <div class="pagination">
                    {!! $projecten->render() !!}

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection

