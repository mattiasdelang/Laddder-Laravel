@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

    <div id="editproject-page" class="container">
        <div class="content">
            <div class="col-md-8 col-md-offset-2">
                <h1>Edit your project</h1>

                <div class="row text-center">
                    <div class="col-lg-4">
                        <img id="edit-project-img" src="/project_images/{{ $image }}" alt="{{ $title }}" />
                    </div>
                    <div class="col-lg-8">
                        <form action="/projects/{{ $projectId }}/edit" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="title">Title</label>

                                <div class="col-sm-9">
                                    <input class="form-control" type="text" id="title" name="title" value="{{ $title }}"
                                           placeholder="Project title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>

                                <div class="col-sm-9">
                                    <input type="text" id="description" name="description" class="form-control" value="{{ $description }}"
                                           placeholder="Project description" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tags" class="col-sm-2 control-label">Tags</label>

                                <div class="col-sm-9">
                                    <input type="text" id="tags" name="tags" class="form-control"
                                           placeholder="Tags, e.g. website, design, mock-up"
                                           value="{{ $tags }}"
                                           required>
                                </div>
                            </div>
                            <input type="hidden" id="projectId" name="projectId" value="{{ $projectId }}">
                            <div class="form-group">
                                <div class="col-sm-offset-9 col-sm-2">
                                    <button type="submit" class="btn btn-default">Update project</button>
                                </div>
                            </div>
                        </form>

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection