<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\Eloquent\Models\ConsommateurModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

beforeEach(function () {
    $this->model = new ConsommateurModel;
});

test('consommateur model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('consommateur model uses consommateurs table', function () {
    expect($this->model->getTable())->toBe('consommateurs');
});

test('consommateur model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('consommateur model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('consommateur model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'nom',
        'telephone',
        'adresse',
    ]);
});

test('consommateur model has id cast to string', function () {
    expect($this->model->getCasts())->toHaveKey('id', 'string');
});

test('consommateur model has commandes hasMany relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('commandes'))->toBeTrue();

    $method = $reflection->getMethod('commandes');

    expect($method->getReturnType()?->getName())
        ->toBe(HasMany::class);
});
