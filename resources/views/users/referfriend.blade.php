@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')

<div id="referfriend-page" class="container">
    
    <div id="pageheader">
        <h1>Invite friends to join Laddder!</h1>
    </div>

    <div class="content">
        <div class="row">

            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</h2>
            @endforeach
            @if(Session::has('message'))
                <p class="alert alert-success">{{ Session::get('message') }}</p>
            @endif  
                  
            <div class="col-lg-4 clearfix">
                <h2>Invite friends</h2>

                <form id="invite" action="/referfriend" class="form-horizontal" method="POST">
                    {!! csrf_field() !!}

                    <div class="col-sm-10 form-group">
                        <input type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                    
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-default btnLaddderOrange"><span>Invite</span></button>
                    </div>

                </form>            
            </div>
            <div class="col-lg-8">
                <h2>List with invitees</h2>
                <ul class="list-group">
                    @foreach($referfriend as $friend)
                        <li class="list-group-item">
                            {{$friend->email}}

                            @if($friend->check == 1)
                                heeft zich aangemeld.
                            @else
                                heeft zich nog niet aangemeld.
                            @endif
                        </li>
                    @endforeach
                </ul>            
            </div>
        </div>
    </div>

</div>








@endsection
