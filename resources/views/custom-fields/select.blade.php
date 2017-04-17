<?php
$options = collect(json_decode($field['options'], true));
$options = $options->combine($options);
$options->prepend('Select Value', '');
?>

<div class="form-group {{$errors->first("cf.{$field['id']}", 'has-error')}}">
    {{ Form::label($name = "cf[{$field['id']}]", $field['name'], ['class' => 'control-label']) }}
    {{ Form::select($name, $options , null, ['class' => 'form-control cf', 'id' => "cf-{$field['id']}"]) }}
    {!! $errors->first("cf.{$field['id']}", '<div class="help-block">:message</div>') !!}
</div>