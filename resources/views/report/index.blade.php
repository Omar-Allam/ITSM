@extends('layouts.app')

@section('header')
    <h4>Ticket Reports</h4>
@endsection

@section('body')

    {{Form::open(['url' => '/report/result', 'id' => "ReportArea"])}}

    <div class="row">
        <div class="col-sm-5">
            <div class="form-group {{$errors->first('fields', 'has-error')}}">
                {{Form::label('field[]', 'Select Fields', ['class' => 'control-label'])}}
                {{Form::select('fields[]', $fields, session('ticket-report.fields'), ['class' => 'form-control', 'multiple', 'size' => 10])}}
                {!! $errors->first('fields', '<div class="help-block">:message</div>') !!}
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Criteria</h4>
        </div>

        <criteria></criteria>
    </div>

    <div class="form-group">
        <button class="btn btn-success"><i class="fa fa-arrow-circle-right"></i> Run Report</button>
    </div>

    {{Form::close()}}
@endsection

@section('javascript')
    <script>
        var fields = {!! json_encode($fields) !!}
    </script>
    <script src="{{asset('/js/report.js')}}"></script>
@endsection