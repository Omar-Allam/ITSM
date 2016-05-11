<?php

namespace App;

/**
 * App\Criterion
 *
 * @property integer $id
 * @property integer $criteria_id
 * @property string $field
 * @property string $operator
 * @property string $label
 * @property string $value
 * @property boolean $next
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereCriteriaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereField($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereOperator($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereNext($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Criterion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Criterion extends KModel
{
    protected $fillable = ['field', 'operator', 'value', 'label'];
}
