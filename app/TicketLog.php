<?php

namespace App;

/**
 * App\TicketLog
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ticket_id
 * @property string $old_data
 * @property string $new_data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereOldData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereNewData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketLog extends KModel
{
    //
}
