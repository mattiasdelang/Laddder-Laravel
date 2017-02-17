@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')


<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/jquery.Jcrop.css') }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/jquery.Jcrop.css') }}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="{{ URL::asset('/js/jquery.color.js') }}"></script>
<script src="{{ URL::asset('/js/jquery.Jcrop.js') }}"></script>
<script src="{{ URL::asset('/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('/js/myJcrop.js') }}"></script>

<script>

    $( document ).ready(function(event) {

//Showing image with file select ////////////////////////////////////////////////////////////////////

        function readURL(input) {

             if (input.files && input.files[0]) {
                 
                 var reader = new FileReader();

                 reader.onload = function (e) {
                    $('#pImage').attr('src', e.target.result);
                 }

             reader.readAsDataURL(input.files[0]);
                 
             }
        }
        
        
//Getting "Real Image" and "Displayed Image" info ////////////////////////////////////////////////////////////////////

        function sendPreviewSize() {

            $previewWidth = $("#preview").width();
            $previewHeight = $("#preview").height();
            
            $('#DisplayWidth').val($previewWidth);
            $('#DisplayHeight').val($previewHeight);
                 
        }
        

        
        
        
//On image load event listener ////////////////////////////////////////////////////////////////////
        

        $("#image_file").change(function(){
            
            if(this.files[0].size < 8000000)
            {
                fileSelectHandler();
                readURL(this);
            
                setTimeout(function(){
                    sendPreviewSize();
                },1020);
            }
            else
            {
                alert('This file is to big bro!');
                $(this).closest('form').find("input[type=file]").val(""); 
            }
            
        });

    });

</script>

<div id="upload-page" class="container">
    
    <div id="pageheader">
        <h1>Challenge time!</h1>
    </div>

    <div class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <h1>Challenge #{{ $challengeId }}: {{ $title }}</h1>
                <p>{{ $description }}</p>
                <div id="challengeDate" class="row">
                    <div class="challengeDate challengeDateL col-sm-6">
                        <span class="glyphicon glyphicon-ok">&nbsp;</span>
                        <span>start: {{ $startdate }}</span>
                    </div>
                    <div class="challengeDate col-sm-6">
                        <span class="glyphicon glyphicon-remove">&nbsp;</span>
                        <span> end: {{ $enddate }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
            @if ($status == 'ongoing')

                <h1>Upload your entry</h1>

                <form action="/challenge" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" id="challengeId" name="challengeId" value="{{ $challengeId }}">
                    
                    <div class="form-group">
                        <label for="pName" class="col-sm-3 control-label">What is the name of your entry?</label>
                        <div class="col-sm-5">
                            <input type="text" id="pName" name="pName" class="form-control" value="{{ Request::old('pName') ?: '' }}">
                        </div>
                    </div>
                    
                    
                <div class="form-group">
                    <label for="imgInput" class="col-sm-3 control-label">Post your image here</label>

                    <div class="col-sm-5">
                          
                        <input type="hidden" id="x1" name="x1" />
                        <input type="hidden" id="y1" name="y1" />
                        <input type="hidden" id="x2" name="x2" />
                        <input type="hidden" id="y2" name="y2" />
                        
                        <input type="hidden" id="RealWidth" name="RealWidth" />
                        <input type="hidden" id="RealHeight" name="RealHeight" />
                        <input type="hidden" id="DisplayWidth" name="DisplayWidth" />
                        <input type="hidden" id="DisplayHeight" name="DisplayHeight" />
                           
                        <!-- <input type="file" id="imgInput" name="imgInput" class="form-control"> -->
                        <div><input type="file" name="image_file" id="image_file"/></div>
                    </div>
                    
                    <div class="col-sm-5">
                       
                        <div class="step2">

                            <img id="preview" />

                            <div class="info" id="imgInfo">
                                <label>File size</label> <input type="text" id="filesize" name="filesize" />
                                <label>Type</label> <input type="text" id="filetype" name="filetype" />
                                <label>Image dimension</label> <input type="text" id="filedim" name="filedim" />
                                <label>W</label> <input type="text" id="w" name="w" />
                                <label>H</label> <input type="text" id="h" name="h" />
                            </div>

                        </div>
                    </div>
                </div>
                    
                    
                    <div class="form-group">
                        <label for="pDescription" class="col-sm-3 control-label">Describe your project</label>
                        <div class="col-sm-5">
                            <textarea name="pDescription" id="pDescription" class="form-control" cols="30" rows="10">{{ Request::old('pDescription') ?: '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pTags" class="col-sm-3 control-label">Add some tags to your project</label>
                        <div class="col-sm-5">
                            <input type="text" id="pTags" name="pTags" class="form-control" value="{{ Request::old('pTags') ?: '' }}">
                            <span class="help-block">Divide tags by a comma. For example: Design, Vector, Logo</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <button type="submit" class="btn btn-default btnLaddderOrange">Upload Work</button>
                        </div>
                    </div>

                </form>

            @elseif ($status == 'over')
                <p class="alert alert-info">
                    Oops, sorry bud! This challenge has ended already and the entries have been closed. <br>
                    <a href="/challenge/{{ $challengeId }}/entries">&raquo; View the entries here and vote for your favorites!</a>
                </p>
            @endif

            </div>
        </div>

    </div>
    </div>

@endsection
