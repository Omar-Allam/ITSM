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
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketReply whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketReply extends KModel
{
    //
}
