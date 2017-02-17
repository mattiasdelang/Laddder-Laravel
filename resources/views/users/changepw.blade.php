@extends('app')

@section('navigation')

    @include('includes.navigation')

@endsection

@section('content')



        <div class="alert-box success">
            <form action="" class="form" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" placeholder="Username" name="username" class="form-control">
                    <label for="current">Current Password(See mail)</label>
                    <input type="password" placeholder="Current password" name="current" class="form-control">
                    <label for="new">New Password</label>
                    <input type="password" placeholder="New password" name="password" class="form-control">
                    <label for="Confirm">Confirm Password</label>
                    <input type="password" placeholder="Confirm password" name="password_confirmation"
                           class="form-control">
                    <input type="submit" value="Change Password" name="changePw" class="form-control">
                </div>
            </form>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


@endsection