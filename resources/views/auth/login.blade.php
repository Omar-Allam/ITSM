@extends('layouts.app')

@section('header')
    <h4 class="panel-title">Login</h4>
@endsection
@section('body')
    <form class="col-sm-8 col-sm-offset-2 form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="login" class="col-sm-4 control-label">Login</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="login" id="login" value="{{ old('login') }}">
                @if ($errors->has('login'))
                    <span class="error-message">{{ $errors->first('login') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="control-label col-sm-4">Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="password" id="password">
                @if ($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> Login
                </button>

                <a href="/auth/google" class="btn btn-danger">
                    <i class="fa fa-btn fa-google-plus"></i> Login using Google
                </a>
            </div>
        </div>
    </form>
@endsection
