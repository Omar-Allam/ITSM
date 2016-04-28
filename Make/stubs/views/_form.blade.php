@{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="form-group @{{$errors->has('name')? 'has-error' : ''}}">
            @{{ Form::label('name', 'Name', ['class' => 'control-label']) }}
            @{{ Form::text('name', null, ['class' => 'form-control']) }}
            {{'@'}}if ($errors->has('name'))
            <div class="error-message">@{{$errors->first('name')}}</div>
            {{'@'}}endif
        </div>

        {{-- Continue working on your fields here --}}

        <div class="form-group">
            <button class="btn btn-success"><i class="fa fa-check"></i> Submit</button>
        </div>
    </div>
</div>
