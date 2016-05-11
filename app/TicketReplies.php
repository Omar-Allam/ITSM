<?php

namespace App;


/**
 * App\TicketReplies
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $ticket_id
 * @property string $content
 * @property integer $status_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReplies whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketReplies extends KModel
{
    //
}
