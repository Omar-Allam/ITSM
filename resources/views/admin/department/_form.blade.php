<div class="row">
    <div class="col-md-6">
        {{csrf_field()}}

        <div class="form-group {{$errors->has('name')? 'has-errors' : ''}}">
            {{Form::label('name', 'Name', ['class' => 'control-label'])}}
            {{Form::text('name', null, ['class' => 'form-control'])}}
            @if ($errors->has('name'))
                <div class="error-message">{{$errors->first('name')}}</div>
            @endif
        </div>

        <div class="form-group {{$errors->has('business_unit_id')? 'has-errors' : ''}}">
            {{Form::label('business_unit_id', 'Business Unit', ['class' => 'control-label'])}}
            {{Form::select('business_unit_id', \App\BusinessUnit::selection('Select Business Unit'), null, ['class' => 'form-control'])}}
            @if ($errors->has('business_unit_id'))
                <div class="error-message">{{$errors->first('business_unit_id')}}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>
</div>