@extends('layouts.app')

@section('header')
    <h3 style="margin: 0;">Application error</h3>
@stop

@section('body')
    <div class="col-sm-8 col-sm-offset-2">
        <div class="alert alert-danger text-center">

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <p><i class="fa fa-exclamation-circle fa-4x"></i></p>

            <p class="lead">
                <strong>An internal application error has occurred</strong>
            </p>

            <p>&nbsp;</p>

            <p><strong>Please contact your system administrator</strong></p>

            <p><strong>Error Code: #{{$log->id}}</strong></p>

            <p>&nbsp;</p>

            <p><a href="#" class="btn btn-default" id="back">
                    <span class="text-danger"><i class="fa fa-chevron-left"></i> Go Back</span>
                </a></p>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
    </div>

@stop

@section('javascript')
    <script>
//        $(function() {
//            $('#back').on('click', function() {
//                window.history.back();
//            });
//        });
    </script>
@endsection