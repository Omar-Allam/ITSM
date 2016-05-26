@extends('layouts.app')

@section('header')
    <h4 class="panel-title">Login</h4>
@endsection
@section('body')
    <form class="col-md-4 col-md-offset-4" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="login" class="control-label">Login</label>
            <input type="text" class="form-control" name="login" id="login" value="{{ old('login') }}">
            @if ($errors->has('login'))
                <span class="error-message">{{ $errors->first('login') }}</span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label">Password</label>
            <input type="password" class="form-control" name="password" id="password">
            @if ($errors->has('password'))
                <span class="error-message">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> Login
                </button>
            </div>
        </div>
    </form>
@endsection
