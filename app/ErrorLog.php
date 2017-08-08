<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    static function log(\Exception $e)
    {
        $log = new ErrorLog();

        $log->message = $e->getMessage();
        $log->severity = $e->getSeverity();
        $log->file = $e->getFile();
        $log->line = $e->getLine();
        $log->code = $e->getCode();
        $log->trace = $e->getTraceAsString();
        $log->user_id = \Auth::id() ?: 0;

        $log->save();

        return $log;
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
