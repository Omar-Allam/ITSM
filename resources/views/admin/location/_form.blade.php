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

        <div class="form-group {{$errors->has('city_id')? 'has-errors' : ''}}">
            {{Form::label('city_id', 'City', ['class' => 'control-label'])}}
            {{Form::select('city_id', \App\City::selectList('Select City'), null, ['class' => 'form-control'])}}
            @if ($errors->has('city_id'))
                <div class="error-message">{{$errors->first('city_id')}}</div>
            @endif
        </div>

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check-circle"></i> Submit</button>
        </div>
    </div>
</div>