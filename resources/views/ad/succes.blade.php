@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

    <div id="upload-page" class="container" xmlns="http://www.w3.org/1999/html">
        <div id="pageheader">
            <h1>Payment successful</h1>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <p class="succesful-ads">your payment was successful :)</p>
                    <p>if you would like to see your advertisement, go check it out: <a href="/homepage">Homepage</a>.</p>
                </div>
            </div>
        </div>
@stop