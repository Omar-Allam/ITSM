<?php

namespace App;

use App\Behaviors\HasCriteria;

/**
 * App\BusinessRule
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property boolean $is_last
 * @property integer $position
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Criteria[] $criteria
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereIsLast($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\BusinessRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessRule extends KModel
{
    use HasCriteria;
    
    protected $fillable = ['name', 'description', 'is_last'];

    protected $dates = ['created_at', 'updated_at'];

    protected $criteriaType = 'rule';

    
    
    public function updateRules($rules)
    {
        $this->rules()->delete();
        return $this->rules()->createMany($rules);
    }

    public function rules()
    {
        return $this->hasMany(BusinessRuleAction::class);
    }
}
