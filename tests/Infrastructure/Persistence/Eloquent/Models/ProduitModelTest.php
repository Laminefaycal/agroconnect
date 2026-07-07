<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\Eloquent\Models\ProduitModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

beforeEach(function () {
    $this->model = new ProduitModel;
});

test('produit model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('produit model uses produits table', function () {
    expect($this->model->getTable())->toBe('produits');
});

test('produit model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('produit model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('produit model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'agriculteur_id',
        'nom',
        'description',
        'prix_unitaire',
    ]);
});

test('produit model has correct casts', function () {
    expect($this->model->getCasts())
        ->toHaveKey('id', 'string')
        ->toHaveKey('prix_unitaire', 'decimal:2');
});

test('produit model has agriculteur belongsTo relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('agriculteur'))->toBeTrue();

    $method = $reflection->getMethod('agriculteur');

    expect($method->getReturnType()?->getName())
        ->toBe(BelongsTo::class);
});
