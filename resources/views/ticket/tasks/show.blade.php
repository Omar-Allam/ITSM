@extends('layouts.app')

@section('header')

@endsection

@section('body')
    <div class="label pull-right">
        <a class="btn btn-default" href="{{url()->previous()}}"><i class="fa fa-arrow-left"> Back</i></a>
    </div>
    <form action="{{route('task.update',$task)}}" method="POST">
        {{csrf_field()}} {{method_field('PUT')}}
        <div class="container">
            <h3 class="header">Edit {{$task->title}}</h3> <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm {{$errors->has('title')? 'has-error' : ''}}">
                        {{Form::label('title', 'Title', ['class' => 'control-label'])}}
                        {{Form::text('title', $task->title, ['class' => 'form-control'])}}
                        @if ($errors->has('title'))
                            <div class="error-message">{{$errors->first('title')}}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm {{$errors->has('description')? 'has-error' : ''}}">
                        {{Form::label('description', 'Description', ['class' => 'control-label'])}}
                        {{Form::textarea('description', $task->description, ['class' => 'form-control'])}}
                        @if ($errors->has('description'))
                            <div class="error-message">{{$errors->first('description')}}</div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm {{$errors->has('priority_id')? 'has-error' : ''}}">
                        {{Form::label('priority_id', 'Priority', ['class' => 'control-label'])}}
                        {{Form::select('priority_id', ['0'=>'Select Priority'] + \App\Priority::pluck('name','id')->toArray(),$task->priority_id, ['class' => 'form-control'])}}
                        @if ($errors->has('priority_id'))
                            <div class="error-message">{{$errors->first('priority_id')}}</div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-group-sm {{$errors->has('technician_id')? 'has-error' : ''}}">
                        {{Form::label('technician_id', 'Technician', ['class' => 'control-label'])}}
                        {{Form::select('technician_id',['0'=>'Select Technician'] +\App\User::technicians()->pluck('name','id')->toArray(),$task->technician_id, ['class' => 'form-control'])}}
                        @if ($errors->has('technician_id'))
                            <div class="error-message">{{$errors->first('technician_id')}}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm {{$errors->has('group_id')? 'has-error' : ''}}">
                        {{Form::label('group_id', 'Group', ['class' => 'control-label'])}}
                        {{Form::select('group_id', ['0'=>'Select Group'] +\App\Group::pluck('name','id')->toArray(),$task->group_id, ['class' => 'form-control'])}}
                        @if ($errors->has('group_id'))
                            <div class="error-message">{{$errors->first('group_id')}}</div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary "> Submit</button>
                <a href="{{route('ticket.show',\App\Ticket::find($task->ticket_id))}}" class="btn btn-default "> Cancel</a>
            </div>
        </div>




    </form>

@endsection

@section('javascript')
    <script src="{{asset('/js/ticket.js')}}"></script>
    <script src="{{asset('/js/tinymce/tinymce.min.js')}}"></script>
@endsection