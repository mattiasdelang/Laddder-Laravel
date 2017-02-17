@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

<div id="tag-page" class="container">

    <div class="content">

        <div class="row">
            <h1><a class="tag_link_header" href="/projects/tag/{{ $tag}}">{{ $tag}}</a></h1>

            <div class="col-lg-9 projects">
                <div class="projects-container">

                    @foreach($projects as $projects)
                        <div class="col-sm-6 col-lg-3 project">
                            <div class="thumbnail">
                                <img src="/project_images/{{$projects->image}}" alt="{{$projects->image}}"/>
                                <div class="caption">
                                    <h3><a href="/projects/{{$projects->projectId}}">{{$projects->title}}</a></h3>
                                    <p>- <a href="/user/profile/{{$projects->userId}}">{{$projects->username}}</a></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection