@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection
@section('style')
	<style>
		#iets0{
			background-color:#ccd7db;
		}
	</style>
@endsection
@section('content')

    <div id="activity-page" class="container">
        <div id="pageheader">
	        <h1>Activity log</h1>
	    </div>

        <div class="content">

		     <ul id="activitylog" class="list-group">
		        @foreach($activities as $activity)

					 @if($activity->source_type == "App\\ProjectLike")

						 <li id="iets{{$activity->seen}}" class="list-group-item">
							 <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
							 <a href="/projects/{{$activity->source->project->projectId}}" >
								 <strong><em>{{ $activity->source->user->username }}</em></strong> has liked your work,
								 {{ $activity->source->project->title }},
								 <cite>&nbsp;{{\Carbon\Carbon::parse($activity->created_at)->diffForHumans() }} </cite>
							 </a>
						 </li>

					 @elseif($activity->source_type == "App\\ProjectComment")

						 <li id="iets{{$activity->seen}}" class="list-group-item">
							 <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
							 <a href="/projects/{{$activity->source->project->projectId}}" >
								 <strong><em>{{ $activity->source->user->username }}</em></strong> has commented on your work,
								 {{ $activity->source->project->title }},
								 <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
							 </a>
						 </li>
					 @elseif($activity->source_type == "App\\UserAchievement")

						 <li id="iets{{$activity->seen}}" class="list-group-item">
							 <span class="glyphicon glyphicon-eye-open">&nbsp;</span>
							 <a href="/achievements" >
								 <strong><em>{{ $activity->source->achievement->name }}</em></strong> has been reached,
								 <cite>&nbsp;{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans()}} </cite>
							 </a>
						 </li>

					 @endif

		        @endforeach
		    </ul>
        </div>
    </div>




@endsection