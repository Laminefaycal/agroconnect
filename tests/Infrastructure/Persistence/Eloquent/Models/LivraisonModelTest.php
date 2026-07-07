<?php

namespace Test\Infrastructure\Persistence\Eloquent\Models;

namespace App\Tests\Infrastructure\Persistence\Eloquent\Models;

use App\Domain\Livraison\StatutLivraison;
use App\Infrastructure\Persistence\Eloquent\Models\LivraisonModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

beforeEach(function () {
    $this->model = new LivraisonModel;
});

test('livraison model extends eloquent model', function () {
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('livraison model uses livraisons table', function () {
    expect($this->model->getTable())->toBe('livraisons');
});

test('livraison model is not incrementing', function () {
    expect($this->model->incrementing)->toBeFalse();
});

test('livraison model key type is string', function () {
    $reflection = new \ReflectionClass($this->model);
    $property = $reflection->getProperty('keyType');

    expect($property->getValue($this->model))->toBe('string');
});

test('livraison model has correct fillable attributes', function () {
    expect($this->model->getFillable())->toBe([
        'id',
        'commande_id',
        'transporteur_id',
        'date_prise_en_charge',
        'date_livraison_effective',
        'statut',
    ]);
});

test('livraison model has correct casts', function () {
    expect($this->model->getCasts())
        ->toHaveKey('id', 'string')
        ->toHaveKey('commande_id', 'string')
        ->toHaveKey('transporteur_id', 'string')
        ->toHaveKey('date_prise_en_charge', 'datetime')
        ->toHaveKey('date_livraison_effective', 'datetime')
        ->toHaveKey('statut', StatutLivraison::class);
});

test('livraison model has commande belongsTo relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('commande'))->toBeTrue();

    $method = $reflection->getMethod('commande');

    expect($method->getReturnType()?->getName())
        ->toBe(BelongsTo::class);
});

test('livraison model has transporteur belongsTo relation method', function () {
    $reflection = new \ReflectionClass($this->model);

    expect($reflection->hasMethod('transporteur'))->toBeTrue();

    $method = $reflection->getMethod('transporteur');

    expect($method->getReturnType()?->getName())
        ->toBe(BelongsTo::class);
});
