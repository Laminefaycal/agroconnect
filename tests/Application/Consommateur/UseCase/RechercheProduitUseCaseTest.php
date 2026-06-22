<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\RechercheProduitUseCase;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;

test('il doit retourner les produits correspondants au mot-clé recherché', function () {
    // Arrange
    $motCle = 'Carotte';
    $resultatRecherche = [['id' => '3', 'nom' => 'Carotte Pourpre']];

    $produitRepository = mock(ProduitRepositoryInterface::class);
    $produitRepository->shouldReceive('searchByKeyword')
        ->with($motCle)
        ->once()
        ->andReturn($resultatRecherche);

    $useCase = new RechercheProduitUseCase($produitRepository);

    // Act
    $resultat = $useCase->execute($motCle);

    // Assert
    expect($resultat)->toBe($resultatRecherche);
});
