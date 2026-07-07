<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\Eloquent\Models\TransporteurModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

beforeEach(function () {
    $this->model = new TransporteurModel;
});

test('transporteur model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('transporteur model uses transporteurs table', function () {
    expect($this->model->getTable())->toBe('transporteurs');
});

test('transporteur model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('transporteur model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('transporteur model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'nom',
        'telephone',
        'type_vehicule',
    ]);
});

test('transporteur model has id cast to string', function () {
    expect($this->model->getCasts())->toHaveKey('id', 'string');
});

test('transporteur model has livraisons hasMany relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('livraisons'))->toBeTrue();

    $method = $reflection->getMethod('livraisons');

    expect($method->getReturnType()?->getName())
        ->toBe(HasMany::class);
});
