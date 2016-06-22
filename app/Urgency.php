<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\Urgency
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Urgency selection($empty = false)
 * @mixin \Eloquent
 */
class Urgency extends KModel
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];

    use Listable;
}