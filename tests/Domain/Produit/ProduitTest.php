<?php

namespace Tests\Domain\Produit;

use App\Domain\Produit\Produit;
use App\Domain\Agriculteur\Agriculteur;
use Mockery;

test('produit est disponible si stock suffisant', function () {
    $produit = new Produit('1', 'Banane', 'Bio', 100.0, 10, 'kg');
    expect($produit->estDisponible(5))->toBeTrue();
    expect($produit->estDisponible(15))->toBeFalse();
});

test('produit décrémente son stock correctement', function () {
    $produit = new Produit('1', 'Manioc', 'Frais', 50.0, 20, 'kg');
    $produit->decrementerStock(5);
    expect($produit->getStock())->toBe(15);
    $produit->decrementerStock(30);
    expect($produit->getStock())->toBe(15);
});


test('Produit associé un agriculteur retourne bien un produit de agriculteur', function () {
    $produit = new Produit('1', 'Banane', 'Bio', 100.0, 10, 'kg');
    $agriculteur = Mockery::mock(Agriculteur::class);
    $produit->setAgriculteur($agriculteur);
    expect($produit->getAgriculteur())->toBe($agriculteur);
});
