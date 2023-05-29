<?php

namespace Tests\Expectations;

use Illuminate\Database\Eloquent\Model;
use Pest\Expectation;

class ModelExpectation
{
    public static function create(Model $model): self
    {
        return new self($model);
    }

    public static function register(): void
    {
        expect()->extend('hasOne', fn (string $relation) => ModelExpectation::hasOne($this, $relation)); // @phpstan-ignore-line
        expect()->extend('hasMany', fn (string $relation) => ModelExpectation::hasMany($this, $relation)); // @phpstan-ignore-line
        expect()->extend('belongsTo', fn (string $relation) => ModelExpectation::belongsTo($this, $relation)); // @phpstan-ignore-line
        expect()->extend('belongsToMany', fn (string $relation) => ModelExpectation::belongsToMany($this, $relation)); // @phpstan-ignore-line
        expect()->extend('hasOneThrough', fn (string $relation) => ModelExpectation::hasOneThrough($this, $relation)); // @phpstan-ignore-line
        expect()->extend('hasManyThrough', fn (string $relation) => ModelExpectation::hasManyThrough($this, $relation)); // @phpstan-ignore-line
        expect()->extend('hasAttributes', fn (array $attributes) => ModelExpectation::hasAttributes($this, $attributes)); // @phpstan-ignore-line
    }

    public static function hasOne(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function hasMany(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function belongsTo(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function belongsToMany(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function hasOneThrough(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function hasManyThrough(Expectation $expect, string $relationship): Expectation
    {
        return $expect;
    }

    public static function hasAttributes(Expectation $expect, array $attributes): Expectation
    {
        return $expect;
    }
}
