{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group {{$errors->has('name')? 'has-error' : ''}}">
            {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
                <div class="error-message">{{$errors->first('name')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('description')? 'has-error' : ''}}">
            {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
            @if ($errors->has('description'))
                <div class="error-message">{{$errors->first('description')}}</div>
            @endif
        </div>

        @include('admin.partials._criteria')

        <div class="panel panel-sm panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title">Due by time</h4>
            </div>
            <div class="panel-body row">
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('due_days')? 'has-error' : ''}}">
                        {{ Form::label('due_days', 'Days', ['class' => 'control-label']) }}
                        {{ Form::text('due_days', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('due_days')? 'has-error' : ''}}">
                        {{ Form::label('due_hours', 'Hours', ['class' => 'control-label']) }}
                        {{ Form::selectRange('due_hours', 0, 23, null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('due_days')? 'has-error' : ''}}">
                        {{ Form::label('due_minutes', 'Minutes', ['class' => 'control-label']) }}
                        {{ Form::selectRange('due_minutes', 0, 59, null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    @if ($errors->has('due_days'))
                        <div class="error-message">{{$errors->first('due_days')}}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="panel panel-sm panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title">First response time</h4>
            </div>
            <div class="panel-body row">
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('response_days')? 'has-error' : ''}}">
                        {{ Form::label('response_days', 'Days', ['class' => 'control-label']) }}
                        {{ Form::text('response_days', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('response_days')? 'has-error' : ''}}">
                        {{ Form::label('response_hours', 'Hours', ['class' => 'control-label']) }}
                        {{ Form::selectRange('response_hours', 0, 23, null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm {{$errors->has('response_days')? 'has-error' : ''}}">
                        {{ Form::label('response_minutes', 'Minutes', ['class' => 'control-label']) }}
                        {{ Form::selectRange('response_minutes', 0, 59, null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-12">
                    @if ($errors->has('response_days'))
                        <div class="error-message">{{$errors->first('response_days')}}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="checkbox">
            <label class="control-label" for="critical">
                {{Form::hidden('critical', false)}}
                {{Form::checkbox('critical', 1, null, ['id' => 'critical'])}}
                Do not honor service hours
            </label>
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
        </div>
    </div>
</div>
