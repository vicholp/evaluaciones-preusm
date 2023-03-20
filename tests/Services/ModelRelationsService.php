<?php

namespace Tests\Services;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelRelationsService
{
    private static function belongsTo($class, $relation, $relatedClass): void
    {
        $model = new $class();

        expect($model)
            ->toBeInstanceOf($class);

        expect($model->$relation())
            ->toBeInstanceOf(BelongsTo::class);

        expect($model->$relation()->getRelated())
            ->toBeInstanceOf($relatedClass);
    }

    public static function testHasMany($testCase, $relation, $relatedClass): void
    {
        $class = $testCase->value;

        $model = new $class();

        expect($model)
            ->toBeInstanceOf($class);

        expect($model->$relation())
            ->toBeInstanceOf(HasMany::class);

        expect($model->$relation()->getRelated())
            ->toBeInstanceOf($relatedClass);

        $fk = $model->$relation()->getForeignKeyName();

        $model = self::createOrGet($class);

        $relatedModel = $relatedClass::factory()->state([$fk => $model->id])->create();

        expect($model->$relation()->first()->is($relatedModel))->toBeTrue();

        $relatedClass::factory()->state([$fk => $model->id])->count(5)->create();

        expect($model->$relation()->count())->toBe(6);
    }

    public static function testMayBelongsTo($testCase, $relation, $relatedClass): void
    {
        $class = $testCase->value;

        self::belongsTo($class, $relation, $relatedClass);

        $model = new $class();

        $fk = $model->$relation()->getForeignKeyName();

        self::testCanBeNull($class, $fk);
    }

    public static function testMustBelongsTo($testCase, $relation, $relatedClass): void
    {
        $class = $testCase->value;

        self::belongsTo($class, $relation, $relatedClass);

        $model = new $class();

        $fk = $model->$relation()->getForeignKeyName();

        self::testCantBeNull($class, $fk);
    }

    public static function testCantBeNull($class, $column): \Pest\Expectation
    {
        return expect(fn () => $class::factory()->state([$column => null])->create())
            ->toThrow("1048 Column '{$column}' cannot be null");
    }

    public static function testCanBeNull($class, $column): \Pest\Expectation
    {
        return expect(fn () => $class::factory()->state([$column => null])->create())
            ->not()->toThrow("1048 Column '{$column}' cannot be null");
    }

    private static function createOrGet($class)
    {
        if (method_exists($class, 'factory')) {
            return $class::factory()->create();
        }

        return $class::inRandomOrder()->first();
    }
}
