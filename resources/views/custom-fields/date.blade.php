<div class="form-group {{$errors->first($name = "cf[{$field['id']}]", 'has-error')}}">
    {{ Form::label($name, $field['name']) }}
    {{ Form::date($name, null, ['class' => 'form-control cf', 'id' => "cf-{$field['id']}"]) }}
    {!! $errors->first($name, '<div class="help-block">:message</div>') !!}
</div>