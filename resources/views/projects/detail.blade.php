@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>
        $("document").ready(function () {
            $("#like").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "../like",
                    data: {projectId: $("#projectId").val()},
                    success: function (data) {
                        $("#dislike_css").show();
                        $("#like_css").hide();
                        $counting = Number($('#likecount').text()) + 1;
                        $("#likecount").html($counting);
                    }
                }, "json");

            });

            $("#dislike").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "../dislike",
                    data: {projectId: $("#projectId2").val()},
                    success: function (data) {
                        $("#dislike_css").hide();
                        $("#like_css").show();
                        $counting = Number($('#likecount').text()) - 1;
                        $("#likecount").html($counting);
                    }
                }, "json");

            });


            $("#comment").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "../comment",
                    data: {
                        projectId: $("#projectId").val(),
                        comment: $("#commentinput").val()
                    },
                    success: function (data) {
                        var inhoud = $("#commentinput").val();
                        var username = $("#userName").val();
                        var commentUserId = $("#commentUserId").val();
                        $('.commentsright ul').prepend($(
                            '<li class="list-group-item row" style="list-style-type:none">' +
                                '<div class="col-xs-2">' +
                                    '<img class="comment_profile_img" src="/profilepics/{{ Auth::user()->image}}" alt="Profile picture">' +
                                '</div>' +
                                '<div class="col-xs-10">' +
                                    '<a href="/user/profile/' + commentUserId + '" class="detailcommentuser">' +
                                        '<p>' + username + '</p>' +
                                    '</a>' +
                                    '<p>' + inhoud + '</p>' +
                                '</div>' +
                            '</li>').hide().slideDown());
                        $("#commentinput").val("");
                    }
                }, "json");

            });

            $(".flag").submit(function (e) {
                $id = "#" + this.id;
                $id_fc = "#li-comment-" + $("#commentId", $id).val();
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "../flag",
                    data: {
                        projectId: $("#projectId", $id).val(),
                        commentId: $("#commentId", $id).val()
                    },
                    success: function (data) {
                        $('#submitflag', $id_fc).attr("disabled", true);
                        $counting = Number($('#flagcount', $id_fc).text()) + 1;
                        $flag = 1;
                        $("#flagcount", $id_fc).html($counting);
                        if ($counting >= 3) {
                            $($id_fc).remove();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr, status, error);
                    }
                }, "json");
            });

            $("#form-delete-project").submit(function (e) {
                e.preventDefault();

                $confirmDelete = confirm("Are you sure you want to delete this project?");
                if ($confirmDelete) {
                    $projectId = $("#projectId").val();

                    $.ajax({
                        type: "POST",
                        url: "../projects/" + $projectId + "/delete",
                        data: {projectId: $projectId},
                        success: function (data) {
                            console.log("Project verwijderd!");
                            window.location = "../homepage";
                        }
                    }, "json");
                }
            });
        })
        ;
    </script>

    <div id="detail-page" class="container">
        <div id="pageheader">
            <h1>Detail</h1>
        </div>
        <div class="detailtotal">
            <div class="detailtop">
                @if (Auth::user()->userId == $userId)
                    {{--ingelogd & dit is je eigen project--}}
                    <a href="/projects/{{$projectId}}/edit" id="edit_project_btn"
                       class="project-action-btn black-tooltip"
                       data-toggle="tooltip" data-placement="bottom" title="Edit project">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    {!! Form::open(array("id"=>"form-delete-project")) !!}
                    {!! Form::hidden('projectId',$projectId) !!}
                    {!! Form::button('<span class="glyphicon glyphicon-remove"></span>', ['type' => 'submit', 'id' => 'remove_project_btn', 'class' => 'project-action-btn black-tooltip', 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => 'Delete project']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
            <div class="detailleft">
                <img id="detailProjectImg" src="/project_images/{{ $image }}" alt="{{ $title }}">
            </div>
            <div class="detailright">
                <div id="detailUserInfo" class="">
                    <img class="userthumb" src="/profilepics/{{$userImage}}" alt="Profile picture">

                    <div class="userText">
                        <h1>{{ $title }}</h1>

                        <p>by <a href="/user/profile/{{$userId}}">{{$username}}</a></p>
                    </div>
                </div>
                <div id="detailDescription" class="">
                    <div class="detaildesc">
                        <p>{{ $description }}</p>
                    </div>
                </div>
                <div id="colorpalette" class="">
                    <span class="glyphicon glyphicon-tint"></span>
                    <ul class="group-colorpalette">
                        <li class="color1">
                            <a href="/projects/tag/{{ substr($colors[0], 1) }}">
                                <div style="background-color: {{ $colors[0] }};"></div>
                            </a>
                        </li>
                        <li class="color2">
                            <a href="/projects/tag/{{ substr($colors[1], 1) }}">
                                <div style="background-color: {{ $colors[1] }};"></div>
                            </a>
                        </li>
                        <li class="color3">
                            <a href="/projects/tag/{{ substr($colors[2], 1) }}">
                                <div style="background-color: {{ $colors[2] }};"></div>
                            </a>
                        </li>
                        <li class="color4">
                            <a href="/projects/tag/{{ substr($colors[3], 1) }}">
                                <div style="background-color: {{ $colors[3] }};"></div>
                            </a>
                        </li>
                        <li class="color5">
                            <a href="/projects/tag/{{ substr($colors[4], 1) }}">
                                <div style="background-color: {{ $colors[4] }};"></div>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="">
                    <div id="detailUsercred">
                        <ul>
                            <li>
                                <span class="glyphicon glyphicon-calendar"></span>

                                <p>{{ $created_at }}</p>
                            </li>
                            <li>
                                <span class="glyphicon glyphicon-heart"></span>

                                <p><span id="likecount">{{ $likecount }}</span> likes</p>
                            </li>
                            <li class="detailTags">
                                @if ( count($tags) > 0 )
                                    <span class="glyphicon glyphicon-tag"></span>
                                    @for ($i = 0; $i < count($tags); $i++)
                                        <p><a href="/projects/tag/{{ $tags[$i] }}">{{ $tags[$i] }}</a></p>
                                    @endfor
                                    <div class="cf"></div>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="">
                    <div id="detailSupport">
                        <ul>
                            <li>
                                <div id="like_css" style="display: {{ $like }}">
                                    {!! Form::open(array("","id"=>"like")) !!}
                                    <span class="glyphicon glyphicon-heart">
                                        {!! Form::hidden('projectId',$projectId, array('id'=>'projectId')) !!}
                                        {!! Form::submit('Like', ['id' => 'submitlike']) !!}</span>
                                    {!! Form::close() !!}
                                </div>
                                <div id="dislike_css" style="display: {{ $dislike }}">
                                    {!! Form::open(array("","id"=>"dislike")) !!}
                                    <span class="glyphicon glyphicon-heart-empty">
                                        {!! Form::hidden('projectId',$projectId, array('id'=>'projectId2')) !!}
                                        {!! Form::submit('Dislike', ['id' => 'submitdislike']) !!}</span>
                                    {!! Form::close() !!}
                                </div>
                            </li>
                            @if ($portfolio)
                                <li>
                                    <span class="glyphicon glyphicon-link"></span>&nbsp;<a
                                            href="http://{{ $portfolio }}">{{ $portfolio }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="commentstotal">
                <div class="commentsleft">
                    <h3>Add a comment:</h3>
                    {!! Form::open(array('url'=>'comment', 'class'=>'form-horizontal', 'id'=>'comment')) !!}
                    {!! Form::hidden('projectId',$projectId) !!}
                    {!! Form::hidden('userId',$userId, array('id'=>'commentUserId')) !!}
                    {!! Form::hidden('userName', Auth::user()->username, array('id'=>'userName')) !!}
                    <div class="">
                        <div class="commentsinput">
                            {!! Form::text('comment','',array('id'=>'commentinput','class'=>'form-control')) !!}
                        </div>
                        <div class="commentssubmit">
                            {!! Form::submit('Post',array('class'=>'btn btn-default')) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="commentsright">
                    <h3>Comments:</h3>
                    <ul class="list-group">
                        @for ($i = 0; $i < count($comment); $i++)
                            @if($comment[$i]->flagCount < 3)
                                <li class="list-group-item row" id="li-comment-{{ $comment[$i]->id }}">
                                    <div class="col-xs-2">
                                        <img class="comment_profile_img" src="/profilepics/{{ $comment[$i]->image }}" alt="Profile picture">
                                    </div>
                                    <div class="col-xs-10">
                                        <a href="/user/profile/{{ $comment[$i]->userId }}" class="detailcommentuser">
                                            <p>{{ $comment[$i]->username }}</p></a>

                                        <div class="flag_css" style="display: inline-block;">
                                            {!! Form::open(array("id"=>"form-" . $comment[$i]->id, "class"=>"flag")) !!}
                                            {!! Form::hidden('projectId',$projectId) !!}
                                            {!! Form::hidden('commentId',$comment[$i]->id) !!}
                                            @if ($flag == 1)
                                                <span class="glyphicon glyphicon-flag flagbutton disabled red-tooltip"
                                                      data-toggle="tooltip" data-placement="right"
                                                      title="You have flagged this comment as inapropriate."></span>
                                            @else
                                                {!! Form::button('<span class="glyphicon glyphicon-flag"></span>', ['type' => 'submit', 'id' => 'submitflag', 'class' => 'flagbutton black-tooltip', 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title' => 'Flag this comment as inapropriate.']) !!}
                                            @endif
                                            {!! Form::close() !!}
                                        </div>
                                        <p>{{ $comment[$i]->comment }}</p>
                                    </div>
                                </li>
                            @endif
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
@endsection