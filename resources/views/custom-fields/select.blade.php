<?php
$options = collect(json_decode($field['options'], true));
$options = $options->combine($options);
$options->prepend('Select Value', '');
?>

<div class="form-group {{$errors->first($name = "cf[{$field['id']}]", 'has-error')}}">
    {{ Form::label($name, $field['name']) }}
    {{
        Form::select($name, $options , null, ['class' => 'form-control cf', 'id' => "cf-{$field['id']}"])
    }}
    {!! $errors->first($name, '<div class="help-block">:message</div>') !!}
</div>