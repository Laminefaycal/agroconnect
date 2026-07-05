<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;
use App\Infrastructure\Persistence\Eloquent\Models\AgriculteurModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

beforeEach(function () {
    $this->model = new AgriculteurModel;
});

test('agriculteur model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('agriculteur model uses agriculteurs table', function () {
    expect($this->model->getTable())->toBe('agriculteurs');
});

test('agriculteur model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('agriculteur model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('agriculteur model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'nom_exploitation',
        'email',
        'telephone',
        'localisation',
    ]);
});

test('agriculteur model has id cast to string', function () {
    expect($this->model->getCasts())->toHaveKey('id', 'string');
});

test('agriculteur model has produits hasMany relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('produits'))->toBeTrue();

    $method = $reflection->getMethod('produits');

    expect($method->getReturnType()?->getName())
        ->toBe(HasMany::class);
});
