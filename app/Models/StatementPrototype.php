<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatementPrototype.
 *
 * @property int                             $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototype whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class StatementPrototype extends Model
{
    use HasFactory;
}
