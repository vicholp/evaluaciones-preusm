<?php

namespace Tests\Expectations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Schema;

class ModelExpectation
{
    public static function hasRelations(
        $class,
        $hasMany = [],
        $belongsTo = [],
        $belongsToMany = [],
        $hasOne = [],
        $hasManyThrough = [],
        $useFactory = true
    ): void {
        describe('relations', function () use (
            $class,
            $hasMany,
            $belongsTo,
            $belongsToMany,
            $hasOne,
            $hasManyThrough,
            $useFactory
        ) {
            self::hasMany($class, $hasMany, $useFactory);
            self::belongsTo($class, $belongsTo, $useFactory);
            self::belongsToMany($class, $belongsToMany, $useFactory);
            self::hasOne($class, $hasOne, $useFactory);
            self::hasManyThrough($class, $hasManyThrough, $useFactory);
        });
    }

    private static function hasMany($class, array $relations, $factory = true): void
    {
        foreach ($relations as $relation) {
            it('has many ' . $relation, function () use ($class, $relation, $factory) {
                if ($factory) {
                    $model = $class::factory()->create();
                } else {
                    $model = $class::inRandomOrder()->first();
                }

                expect($model->$relation())->toBeInstanceOf(HasMany::class);
                expect(Schema::getColumnListing($model->$relation()->getRelated()->getTable()))
                    ->toContain($model->$relation()->getForeignKeyName());
            });
        }
    }

    private static function belongsTo($class, array $relations, $factory = true): void
    {
        foreach ($relations as $relation) {
            it('belongs to ' . $relation, function () use ($class, $relation, $factory) {
                if ($factory) {
                    $model = $class::factory()->create();
                } else {
                    $model = $class::inRandomOrder()->first();
                }

                expect($model->$relation())->toBeInstanceOf(BelongsTo::class);
                expect(Schema::getColumnListing($model->getTable()))
                    ->toContain($model->$relation()->getOwnerKeyName());
            });
        }
    }

    public static function belongsToMany($class, array $relations, $factory = true): void
    {
        foreach ($relations as $relation) {
            it('belongs to many ' . $relation, function () use ($class, $relation, $factory) {
                if ($factory) {
                    $model = $class::factory()->create();
                } else {
                    $model = $class::inRandomOrder()->first();
                }

                expect($model->$relation())->toBeInstanceOf(BelongsToMany::class);
            });
        }
    }

    public static function hasOne($class, array $relations, bool $factory = true): void
    {
        foreach ($relations as $relation) {
            it('has one ' . $relation, function () use ($class, $relation, $factory) {
                if ($factory) {
                    $model = $class::factory()->create();
                } else {
                    $model = $class::inRandomOrder()->first();
                }

                expect($model->$relation())->toBeInstanceOf(HasOne::class);
            });
        }
    }

    public static function hasManyThrough($class, array $relations, bool $factory = true): void
    {
        foreach ($relations as $relation) {
            it('has many through ' . $relation, function () use ($class, $relation, $factory) {
                if ($factory) {
                    $model = $class::factory()->create();
                } else {
                    $model = $class::inRandomOrder()->first();
                }

                expect($model->$relation())->toBeInstanceOf(HasManyThrough::class);
            });
        }
    }
}
