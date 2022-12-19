<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TagGroup
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $kind
 * @method static \Database\Factories\TagGroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereKind($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TagGroup extends Model
{
    use HasFactory;
}
