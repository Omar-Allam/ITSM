<?php

namespace App;

use App\Behaviors\Listable;

/**
 * App\Impact
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Impact selection($empty = false)
 * @mixin \Eloquent
 */
class Impact extends KModel
{
    protected $fillable = ['name', 'description'];

    protected $dates = ['created_at', 'updated_at'];

    use Listable;
}