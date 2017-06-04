<?php

function flash($message, $type = 'danger')
{
    Session::flash('flash-message', $message);
    Session::flash('flash-type', $type);
}

function can($ability, $object)
{
    return \Gate::allows($ability, $object);
}

function cannot($ability, $object)
{
    return \Gate::denies($ability, $object);
}