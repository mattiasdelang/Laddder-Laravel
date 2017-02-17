@extends('app') 
@section('content')
<div id="register-page" class="container">

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


			@if(Session::has('message'))
				<div class="alert alert-success">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif

		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form id="signup" action="/register" class="form" method="POST">
					<h2>Register</h2>

					{!! csrf_field() !!}
					<div class="group">
						<input type="email" name="email" value="{{ old('email') }}" required>
						<label>Email</label>
					</div>
					<div class="group">
						<input type="text" name="name" value="{{ old('name') }}" required>
						<label>Username</label>
					</div>
					<div class="group">
						<input type="password" name="password" required>
						<label>Password</label>
					</div>
					<div class="group">
						<input type="password" name="password_confirmation" required>
						<label>Confirm password</label>
					</div>
					<button class="btnLogin" type="submit"><span>Sign up</span></button>
				
					<p>* Thomas More students will be registered immediately.</p>
					<p>** Other students will be added to the waiting list until further notice.</p>
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