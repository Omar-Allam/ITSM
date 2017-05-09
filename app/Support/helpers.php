<?php

function flash($message, $type = 'danger')
{
    Session::flash('flash-message', $message);
    Session::flash('flash-type', $type);
}