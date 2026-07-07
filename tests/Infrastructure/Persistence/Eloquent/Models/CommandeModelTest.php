<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;

use App\Infrastructure\Persistence\Eloquent\Models\CommandeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

beforeEach(function () {
    $this->model = new CommandeModel;
});

test('commande model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('commande model uses commandes table', function () {
    expect($this->model->getTable())->toBe('commandes');
});

test('commande model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('commande model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('commande model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'consommateur_id',
        'date_commande',
        'statut',
        'mode_livraison',
    ]);
});

test('commande model has id cast to string', function () {
    expect($this->model->getCasts())->toHaveKey('id', 'string');
});

test('commande model has consommateur belongsTo relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('consommateur'))->toBeTrue();

    $method = $reflection->getMethod('consommateur');

    expect($method->getReturnType()?->getName())
        ->toBe(BelongsTo::class);
});

test('commande model has lignes hasMany relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('lignes'))->toBeTrue();

    $method = $reflection->getMethod('lignes');

    expect($method->getReturnType()?->getName())
        ->toBe(HasMany::class);
});

test('commande model has livraison hasOne relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('livraison'))->toBeTrue();

    $method = $reflection->getMethod('livraison');

    expect($method->getReturnType()?->getName())
        ->toBe(HasOne::class);
});
