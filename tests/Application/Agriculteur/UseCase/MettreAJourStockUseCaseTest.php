<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\MettreAJourStockUseCase;
use App\Domain\Repository\ProduitRepositoryInterface;

test('il peut être instancié avec un dépôt de produits', function () {
    // Arrange
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Act
    $useCase = new MettreAJourStockUseCase($produitRepositoryMock);

    // Assert
    expect($useCase)->toBeInstanceOf(MettreAJourStockUseCase::class);
});

test('il exécute la mise à jour du stock sans erreur', function () {
    // Arrange
    $produitId = 'prod-xyz';
    $nouvelleQuantite = 150; // Exemple : 150 kg de bananes ou de manioc

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Ici, vous préparerez l'attente du mock une fois votre logique codée.
    // Par exemple, si votre repository doit sauvegarder ou si le usecase cherche d'abord le produit :
    // $produitRepositoryMock->shouldReceive('trouverParId')->with($produitId)->andReturn($unProduitEntity);

    $useCase = new MettreAJourStockUseCase($produitRepositoryMock);

    // Act & Assert
    // Puisque la méthode retourne 'void', on vérifie qu'elle s'exécute sans lever d'exception
    expect(fn() => $useCase->execute($produitId, $nouvelleQuantite))->not->toThrow(Exception::class);
});
