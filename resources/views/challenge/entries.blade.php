@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script>
        $("document").ready(function(){
            $(".vote").submit(function(e){
                e.preventDefault();

                pId = $(this.projectId).val();
                $.ajax({
                    type: "POST",
                    url : "../vote",
                    data: { projectId: pId },
                    success : function(data){
                        var val = this['data'];
                        var id = val.substr(val.indexOf("=") + 1);
                        $(".vote" + id).hide();
                        $(".unvote" + id).show();
                        var countinc = $('.votecount' + id).text();
                        countinc = Number(countinc) + 1;
                        $(".votecount" + id).html(countinc);
                    }
                },"json");

            });

            $(".unvote").submit(function(e){
                e.preventDefault();

                pId2 = $(this.projectId).val();
                $.ajax({
                    type: "POST",
                    url : "../unvote",
                    data: { projectId: pId2 },
                    success : function(data){
                        var val = this['data'];
                        var id = val.substr(val.indexOf("=") + 1);
                        $(".vote" + id).show();
                        $(".unvote" + id).hide();
                        var countinc = $('.votecount' + id).text();
                        countinc = Number(countinc) - 1;
                        $(".votecount" + id).html(countinc);
                    }
                },"json");

            });
        });
    </script>

    <div id="entries-page" class="container">
    
    <div id="pageheader">
        <h1>Challenge #{{ $id }}: These are the entries!</h1>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <h2><a href="/challenge/{{$id}}">Back to the challenge information</a></h2>

                @if ($data['status'] == 'over')
                    <p class="alert alert-info">Voting is over. These are the final results!</p>
                @endif
            </div>
        </div>

        <div class="row">
                    @foreach($entries as $entry)
                        <div class="col-sm-6 col-lg-3 project">
                            <div class="thumbnail">
                                <img src="/project_images/{{$entry->image}}" alt="{{$entry->title}}"/>
                                <p>Votes: <span class="votecount{{$entry->projectId}}">{{$entry->voteCount}}</span></p>

                            @if ($data['status'] == 'ongoing')
                                <p style="display:none">{{ $voted = 0 }}</p>
                                @foreach($vote as $votes)
                                    @if ($entry->projectId == $votes->projectId)
                                        <div class="unvote_css">
                                            {!! Form::open(array("","class"=>"unvote")) !!}
                                            {!! Form::hidden('projectId',$entry->projectId, array('class'=>'projectId2')) !!}
                                            {!! Form::submit('Unvote', ['id' => 'submitunvote',"class"=>"unvote$entry->projectId"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="vote_css vote{{ $entry->projectId }}" style="display:none">
                                            {!! Form::open(array("","class"=>"vote")) !!}
                                            {!! Form::hidden('projectId',$entry->projectId, array('class'=>'projectId')) !!}
                                            {!! Form::submit('Vote', ['id' => 'submitvote']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <p style="display:none">{{ $voted++ }}</p>
                                    @endif
                                @endforeach

                                @if ($voted != 1)
                                        <div class="vote_css">
                                            {!! Form::open(array("","class"=>"vote")) !!}
                                            {!! Form::hidden('projectId',$entry->projectId, array('class'=>'projectId')) !!}
                                            {!! Form::submit('Vote', ['id' => 'submitvote',"class"=>"vote$entry->projectId"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="unvote_css unvote{{ $entry->projectId }}" style="display:none">
                                            {!! Form::open(array("","class"=>"unvote")) !!}
                                            {!! Form::hidden('projectId',$entry->projectId, array('class'=>'projectId2')) !!}
                                            {!! Form::submit('Unvote', ['id' => 'submitunvote']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                @endif

                            @endif
                            </div>
                        </div>
                    @endforeach
                </div>

    </div>

    </div>


@endsection