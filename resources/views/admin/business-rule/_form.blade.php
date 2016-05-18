{{ csrf_field() }}
<div id="BusinessRules">
    <div class="row">
        <div class="col-md-6">
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

            <div class="checkbox">
                <label class="control-label" for="is_last">
                    {{Form::hidden('is_last', 0)}}
                    {{Form::checkbox('is_last', 1, null, ['id' => 'is_last'])}}
                    Stop applying rules after this one
                </label>
            </div>
        </div>
    </div>

    @include('admin.partials._criteria')
    @include('admin.business-rule._rules')

    <div class="form-group">
        <button class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
    </div>
    </div>
<script type="text/javascript" src="{{asset('/js/business-rules.js')}}"></script>
