@{{ csrf_token() }}

<div class="form-group @{{$errors->has('name')? 'has-error' : ''}}">
    @{{ Form::label('name', 'Name', ['class' => 'control-label']) }}
    @{{ Form::text('name', null, ['class' => 'form-control']) }}
    {{'@'}}if ($errors->has('name'))
        <div class="error-message">@{{$errors->first('name')}}</div>
    {{'@'}}endif
</div>