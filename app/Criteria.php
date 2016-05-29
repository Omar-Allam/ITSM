<?php

namespace App;

/**
 * App\Criteria
 *
 * @property integer $id
 * @property string $relation
 * @property integer $relation_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Criterion[] $criteria
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereRelationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criteria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Criteria extends KModel
{
    const ALL = 1;
    const ANY = 2;

    protected $fillable = ['relation', 'type'];

    public function criteria()
    {
        return $this->hasMany(Criterion::class);
    }
}
