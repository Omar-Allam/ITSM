<?php

namespace App;

use App\Behaviors\Listable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Status
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $type
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Status extends KModel
{
    const OPEN = 1;
    const PENDING = 2;
    const COMPLETE = 3;

    use Listable;

    public static $types = [
        self::OPEN => 'Open',
        self::PENDING => 'Pending',
        self::COMPLETE => 'Completed'
    ];

    protected $fillable = ['name', 'description', 'type'];

    protected $dates = ['created_at', 'updated_at'];

    public function scopeReply(Builder $q, Ticket $ticket)
    {
        $not = [6, $ticket->status_id];

        if (\Auth::user()->isTechnician()) {
            $not[] = 8;
        }

        $q->whereNotIn('id', $not);
    }

    public function isOpen()
    {
        return $this->type == self::OPEN;
    }
}