@extends('app')


@section('content')
    <div id="login-page" class="container">

        <div class="content">
            <div id="intro">

                <header class="page-top clearfix">
                    <div class="pull-left">
                        <a href="/"><h1 id="logo">Laddder</h1></a>
                    </div>

                    <div class="pull-right">
                        <nav class="navigation clearfix">
                            <ul class="clearfix">
                                <li><a class="btnLogin" href="/register"><span>Register</span></a></li>
                            </ul>
                        </nav>          
                    </div>
                </header>
            </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <form id="login" action="/login" class="form" method="POST">
                    
                    <h2>Login</h2>

                    {!! csrf_field() !!}
                    <div class="group">
                        <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="group">
                        <input type="password" placeholder="password" name="password" class="" required>
                    </div>

                    <button class="btnLogin" type="submit"><span>Log in</span></button>

                </form>

                @if(Session::has('message'))
                    <div class="alert alert-danger">
                        <p>{{ Session::get('message') }}</p>
                    </div>
                @endif
            </div>
        </div>

        

        </div>
    </div>


@endsection