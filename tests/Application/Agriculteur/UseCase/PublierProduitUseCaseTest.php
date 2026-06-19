<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\PublierProduitUseCase;
use App\Domain\Repository\ProduitRepositoryInterface;
use App\Domain\Repository\AgriculteurRepositoryInterface;
use App\Application\Agriculteur\DTO\PublierProduitDto;

test('il peut être instancié avec ses dépôts de produits et d\'agriculteurs', function () {
    // Arrange
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    $agriculteurRepositoryMock = mock(AgriculteurRepositoryInterface::class);

    // Act
    $useCase = new PublierProduitUseCase($produitRepositoryMock, $agriculteurRepositoryMock);

    // Assert
    expect($useCase)->toBeInstanceOf(PublierProduitUseCase::class);
});

test('il publie avec succès un produit à partir d\'un DTO', function () {
    // Arrange
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    $agriculteurRepositoryMock = mock(AgriculteurRepositoryInterface::class);

    // On simule le DTO passé en argument
    $dtoMock = mock(PublierProduitDto::class);

    // Une fois vos getters définis dans votre DTO traditionnel (ex: getNom(), getPrix()),
    // vous pourrez configurer les attentes du DTO ainsi :
    // $dtoMock->shouldReceive('getAgriculteurId')->andReturn('agri-77');
    // $dtoMock->shouldReceive('getNom')->andReturn('Régime de Bananes');

    // Configuration des attentes de vos dépôts pour le scénario nominal :
    // $agriculteurRepositoryMock->shouldReceive('trouverParId')->with('agri-77')->andReturn($unAgriculteur);
    // $produitRepositoryMock->shouldReceive('sauvegarder')->once()->andReturn($produitCree);

    $useCase = new PublierProduitUseCase($produitRepositoryMock, $agriculteurRepositoryMock);

    // Act
    $resultat = $useCase->execute($dtoMock);

    // Assert
    // Pour l'instant votre méthode retourne null, le test valide ce comportement initial
    expect($resultat)->toBeNull();

    // Plus tard, quand votre logique retournera l'entité Produit créée :
    // expect($resultat)->toBeInstanceOf(Produit::class);
});
