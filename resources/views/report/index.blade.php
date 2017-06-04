@extends('layouts.app')

@section('header')
    <h4>Ticket Reports</h4>
@endsection

@section('body')

    {{Form::open(['url' => '/report/result', 'id' => "ReportArea", 'class' => 'col-sm-12'])}}

    <div class="form-group {{ $errors->first('title', 'has-error') }}">
       <label for="report-title" class="control-label">Title</label>
       <input type="text" name="title" class="form-control" id="report-title" value="{{$title}}">
       {!! $errors->first('title', '<div class="help-block">:messahe</div>') !!}
     </div>

    <fields :original="{{ json_encode($fields) }}" :initial="{{ json_encode($selectedFields) }}"></fields>


    <section>
      <h4>Criteria</h4>
      <criteria :criterions="{{ json_encode($filters) }}"></criteria>
    </section>

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
