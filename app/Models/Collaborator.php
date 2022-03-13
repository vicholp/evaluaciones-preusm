<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Collaborator
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $subject_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collaborator whereUserId($value)
 * @mixin \Eloquent
 */
class Collaborator extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
    ];
}
