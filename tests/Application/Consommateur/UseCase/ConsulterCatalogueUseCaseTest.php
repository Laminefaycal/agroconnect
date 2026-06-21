<?php

namespace Test\Application\Consommateur\UseCase;


use App\Application\Consommateur\UseCase\ConsulterCatalogueUseCase;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;

test('il doit retourner la liste des produits disponibles du catalogue', function () {
    // 1. Arrange (Préparation)
    $produitsSimules = [
        ['id' => '1', 'nom' => 'Tomate Bio', 'prix' => 2.5],
        ['id' => '2', 'nom' => 'Pomme de terre', 'prix' => 1.8]
    ];

    // Création du mock pour l'interface du Repository
    $produitRepository = mock(ProduitRepositoryInterface::class);
    $produitRepository->shouldReceive('findAllAvailable')
        ->once()
        ->andReturn($produitsSimules);

    $useCase = new ConsulterCatalogueUseCase($produitRepository);

    // 2. Act (Action)
    $resultat = $useCase->execute();

    // 3. Assert (Vérification)
    expect($resultat)->toBeArray()
        ->and($resultat)->toHaveCount(2)
        ->and($resultat[0]['nom'])->toBe('Tomate Bio');
});
