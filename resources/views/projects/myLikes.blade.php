@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

<div id="likes-page" class="container">

    
    <div class="content">


    <h1>These are all the projects you liked so far</h1>

 		
 		<ul id="activitylog" class="list-group">

        @foreach($likes as $like)

        	<li class="list-group-item"><a href="/projects/{{$like->projectId}}">{{ $like->title }}</a></li>

        @endforeach

        </ul>


    </div>

    </div>
@stop