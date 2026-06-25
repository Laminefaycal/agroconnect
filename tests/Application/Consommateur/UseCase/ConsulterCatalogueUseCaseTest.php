<?php

namespace Test\Application\Consommateur\UseCase;


use App\Application\Consommateur\UseCase\ConsulterCatalogueUseCase;
use App\Domain\Produit\ProduitRepositoryInterface;
use App\Domain\Produit\Produit;

it('extrait la liste de tous les produits actifs et disponibles du catalogue', function () {
    // 1. ARRANGEMENT
    $produitMock1 = mock(Produit::class);
    $produitMock2 = mock(Produit::class);
    $catalogueAttendu = [$produitMock1, $produitMock2];

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    // On s'attend à ce que le Use Case filtre strictement sur la disponibilité à true
    $produitRepositoryMock->shouldReceive('findByDisponibilite')
        ->once()
        ->with(true)
        ->andReturn($catalogueAttendu);

    // 2. ACT
    $useCase = new ConsulterCatalogueUseCase($produitRepositoryMock);
    $resultat = $useCase->execute();

    // 3. ASSERT
    expect($resultat)->toBeArray()
        ->toHaveCount(2)
        ->toBe($catalogueAttendu);
});
