<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\RechercheProduitUseCase;
use App\Domain\Produit\Produit;
use App\Domain\Produit\ProduitRepositoryInterface;

it('retourne la liste des produits correspondants au mot-clé nettoyé', function () {
    // 1. ARRANGEMENT
    $keywordBrut = '   Manioc   ';
    $keywordNettoye = 'Manioc';

    $produitMock1 = mock(Produit::class);
    $produitMock2 = mock(Produit::class);
    $resultatAttendu = [$produitMock1, $produitMock2];

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    $produitRepositoryMock->shouldReceive('search')
        ->once()
        ->with($keywordNettoye)
        ->andReturn($resultatAttendu);

    // 2. ACT
    $useCase = new RechercheProduitUseCase($produitRepositoryMock);
    $resultat = $useCase->execute($keywordBrut);

    // 3. ASSERT
    expect($resultat)->toBeArray()
        ->toHaveCount(2)
        ->toBe($resultatAttendu);
});

it('lève une exception de type InvalidArgumentException si le mot-clé est vide ou composé uniquement d’espaces', function (string $keywordInvalide) {
    // 1. ARRANGEMENT
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    $produitRepositoryMock->shouldNotReceive('search');

    $useCase = new RechercheProduitUseCase($produitRepositoryMock);

    // 2. ACT & ASSERT
    expect(fn () => $useCase->execute($keywordInvalide))
        ->toThrow(\InvalidArgumentException::class, 'Le mot-clé de recherche ne peut pas être vide.');
})->with([
    'chaîne totalement vide' => '',
    'chaîne avec uniquement des espaces' => '    ',
    'chaîne avec tabulations et retours à la ligne' => "\t\n  ",
]);
