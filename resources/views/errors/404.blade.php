@extends('layouts.app')

@section('header')
    <h4 class="flex" style="margin-bottom: 0">Page not found</h4>
@stop

@section('body')
<div class="col-sm-8 col-sm-offset-2">
    <div class="alert alert-warning text-center">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <p><i class="fa fa-exclamation-triangle fa-4x"></i></p>

        <p class="lead"><strong>Sorry, the page you are trying to access is not found</strong></p>

        <p>&nbsp;</p>

        <p><strong><small>URL: <a href="{{request()->getUri()}}">{{ request()->getUri() }}</a></small></strong></p>

        <p>&nbsp;</p>

        <p><a href="{{URL::previous('/')}}" class="btn btn-default">
                <span class="text-warning"><i class="fa fa-chevron-left"></i> Go Back</span>
            </a></p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>


    </div>
</div>
@stop