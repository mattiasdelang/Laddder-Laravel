@extends('app')
@section('content')

    <div id="welcome-page" class="container">
        <div class="content">
            <div id="intro">
                <header class="page-top clearfix">
                    <div class="pull-left">
                        <a href="/"><h1 id="logo">Laddder</h1></a>
                    </div>
                    <div class="pull-right">
                        <nav class="navigation clearfix">
                            <ul class="clearfix">
                                <li><a class="btnLogin" href="/login"><span>Login</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </header>
                <div id="laddder-intro" class="row">
                    <div class="">
                        <h2>Started from the bottom, <br> now we're here.</h2>

                        <p><strong>Share</strong> and <strong>showcase</strong> your best designs with other passionate
                            students.</p>
                        <a id="btnSignupHome" href="/register" class="btnLogin"><span>Sign up</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection