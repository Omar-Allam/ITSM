<div class="form-group {{$errors->first($name = "cf[{$field['id']}]", 'has-error')}}">
    <div class="checkbox">
        <label>
            {{ Form::hidden($name, 0) }}
            {{ Form::checkbox($name, 1, null, ['class' => 'cf', 'id' => "cf-{$field['id']}"]) }}
            {{ $field['name'] }}
        </label>
    </div>
    {!! $errors->first($name, '<div class="help-block">:message</div>') !!}
</div>