@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection


@section('content')

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

            <h1>Search Results</h1>

            <div class="col-lg-3 filters">
                <a href="/create" id="btnAddWork" class="">Add work</a>
                <h2>Filters</h2>
                <p>Placeholder</p>
                                <form id="search" action="/search" class="form" method="POST">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="group">
                        <input type="text"name ="search" id="search" class="form-control" placeholder="Search">
                    </div>
                </form>
            </div>
             <div class="col-lg-9 searchresults">

            <h2>Users:</h2>
                
                @if (count($usersearch) === 0)
                        No users results found :(
                @elseif (count($usersearch) >= 1)

                    @foreach($usersearch as $search)

                         <h3> <a href="/user/profile/{{$search->userId}}">{{$search->username}}</a></h3><br>
                    @endforeach
                @endif
                <h2>Projects title:</h2>

                <div class="projects-container">


                    @if (count($projectsearch) === 0 )
                        No works results found :(
                     @elseif (count($projectsearch) >= 1)

                        @foreach($projectsearch as $projecten)
                            <div class="col-sm-6 col-lg-3 project">
                                <div class="thumbnail">
                                    <img src="/project_images/{{$projecten->image}}" alt="{{$projecten->image}}"/>
                                    <div class="caption">
                                        <h3><a href="/projects/{{$projecten->projectId}}">{{$projecten->title}}</a></h3>
                                        <p id="captionUsername">- <a href="/user/profile/{{$projecten->userId}}">{{$projecten->username}}</a></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                @endif
                </div>
                <h2>Tags:</h2>
                <div class="projects-container">

                

                @if (count($tagsearch) === 0 )
                    <p>
                        No works with <span div="searchquery" style="color:orange">{{$query}}</span> as tag found :(
                    </p>
                     @elseif (count($tagsearch) >= 1)

                        @foreach($tagsearch as $tags)
                            <div class="col-sm-6 col-lg-3 project">
                                <div class="thumbnail">
                                    <img src="/project_images/{{$tags->image}}" alt="{{$tags->image}}"/>
                                    <div class="caption">
                                        <h3><a href="/projects/{{$tags->projectId}}">{{$tags->title}}</a></h3>
                                        <p id="captionUsername">- <a href="/user/profile/{{$tags->userId}}">{{$tags->username}}</a></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

