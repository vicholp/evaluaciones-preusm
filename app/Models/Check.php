<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Check.
 *
 * @property int                                                                           $id
 * @property string                                                                        $name
 * @property string                                                                        $description
 * @property \Illuminate\Support\Carbon|null                                               $created_at
 * @property \Illuminate\Support\Carbon|null                                               $updated_at
 * @property string|null                                                                   $slug
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnairePrototype[] $questionnairePrototypes
 * @property int|null                                                                      $questionnaire_prototypes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Check newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Check query()
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Check whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Check extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function questionPrototypes()
    {
        return $this->belongsToMany(QuestionPrototype::class);
    }
}
