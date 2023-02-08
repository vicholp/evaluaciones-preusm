<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatementPrototypeVersion
 *
 * @property int $id
 * @property int $statement_prototype_id
 * @property string|null $name
 * @property string|null $description
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereStatementPrototypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StatementPrototypeVersion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatementPrototypeVersion extends Model
{
    use HasFactory;
}
