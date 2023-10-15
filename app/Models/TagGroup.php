<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TagGroup
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $kind
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static Builder|TagGroup default()
 * @method static \Database\Factories\TagGroupFactory factory($count = null, $state = [])
 * @method static Builder|TagGroup newModelQuery()
 * @method static Builder|TagGroup newQuery()
 * @method static Builder|TagGroup query()
 * @method static Builder|TagGroup whereCreatedAt($value)
 * @method static Builder|TagGroup whereId($value)
 * @method static Builder|TagGroup whereKind($value)
 * @method static Builder|TagGroup whereName($value)
 * @method static Builder|TagGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TagGroup extends Model
{
    use HasFactory;

    /**
     * @return HasMany<Tag>
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * @param Builder<TagGroup> $query
     *
     * @return Builder<TagGroup>
     */
    public function scopeDefault($query)
    {
        return $query->whereIn('name', [
            'skill',
            'topic',
            'subtopic',
            'item_type',
        ]);
    }
}
