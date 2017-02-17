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
   
    <div id="upload-page" class="container" xmlns="http://www.w3.org/1999/html">
       
        <div id="pageheader">
            <h1>Create an advertisement</h1>
        </div>
        
               
        @if (count($errors) > 0)
            <br>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <br>
        @endif
       
        <div class="content">

            <div class="row">

                <div class="col-md-12">

                    <p id="btnAddWork">Placing your advertisement on our site costs € 200 for a month</p>

                    <form action="/ads/create" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="aName" class="col-sm-3 control-label">Give your advertisement a name</label>
                            <div class="col-sm-5">
                                <input type="text" id="aName" name="aName" class="form-control">
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
                            <label for="aLink" class="col-sm-3 control-label">Which URL should the advertisement link to?</label>
                            <div class="col-sm-5">
                                <input type="text" id="aLink" name="aLink" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="aLink" class="col-sm-3 control-label"></label>
                            <div class="col-sm-5">
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="pk_test_JFk76MuR4HE6FC6bfgtBM28F"
                                        data-amount="5000"
                                        data-name="Ladder"
                                        data-description="1 advertisement for a month (€50.00)"
                                        data-image="/128x128.png"
                                        data-locale="auto">
                                    </script>
                            </div>
                        </div>


                    </form>

                </div>

            </div>

        </div>

@stop