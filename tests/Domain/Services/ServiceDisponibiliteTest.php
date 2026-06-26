<?php

namespace Tests\Domain\Services;

use App\Domain\Produit\Produit;
use App\Domain\Services\ServiceDisponibilite;

test('verifierStock retourne vrai si stock suffisant', function () {
    $produit = new Produit('Arachide', 'Bio', 200.0, 50, 'kg','p1');
    $service = new ServiceDisponibilite;
    expect($service->verifierStock($produit, 30))->toBeTrue();
    expect($service->verifierStock($produit, 60))->toBeFalse();
});
