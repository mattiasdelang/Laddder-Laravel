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
<script src="{{ URL::asset('/js/myJcrop_pp.js') }}"></script>

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

    <div id="editprofile-page" class="container">

        <div class="content">
         <div class="row">    
            <div class="col-md-8 col-md-offset-2">

            <h1>Edit your profile</h1>


            <form action="/user/edit-profile" method="POST" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                
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
                    <label class="col-sm-2 control-label" for="portfolio">Portfolio URL</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" id="portfolio" name="portfolio" value="{{ Auth::user()->portfolio }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="twitter" class="col-sm-2 control-label">Twitter</label>
                    <div class="col-sm-10">
                        <input type="text" id="twitter" name="twitter" class="form-control" value="{{ Auth::user()->twitter }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="facebook" class="col-sm-2 control-label">Facebook</label>
                    <div class="col-sm-10">
                        <input type="text" id="facebook" name="facebook" class="form-control" value="{{ Auth::user()->facebook }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="opleiding" class="col-sm-2 control-label">Opleiding</label>
                    <div class="col-sm-10">
                        <input type="text" id="opleiding" name="opleiding" class="form-control" value="{{ Auth::user()->opleiding }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Save</button>
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
@endsection