@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')
	<div id="follower-page" class="container">
   
    <div id="pageheader">
        <h1>Followers</h1>
    </div>
    
    <div class="content">
    	
		<div class="col-lg-2">
            <h3>My followers</h3>
            @if(!$followers->count())
                <p>You have no followers yet.</p>
            @else
            <ul class="list-group">
                @foreach ($followers as $follower)
                    <li class="list-group-item">
                    	<img style="width:30px;" src="/profilepics/{{ $follower->image }}" alt="">
                    	<a href="/user/profile/{{ $follower->userId }}">{{ $follower->username }}</a>
                    </li>
                @endforeach
            @endif
            </ul>
        </div>
        <div class="col-lg-2">
            <h3>Following</h3>
            @if(!$following->count())
                <p>You aren't following anyone yet.</p>
            @else
            <ul class="list-group">
                @foreach ($following as $follower)
                    <li class="list-group-item">
                        <img style="width:30px;" src="/profilepics/{{ $follower->image }}" alt="">
                    	<a href="/user/profile/{{ $follower->userId }}">{{ $follower->username }}</a>
                    </li>
                @endforeach
            @endif
            </ul>
        </div>
<!--         <div class="col-lg-8">
        	<h3>My follow feed</h3>
        	<p>list projects of people I follow here</p>
        </div> -->
    </div>
@stop