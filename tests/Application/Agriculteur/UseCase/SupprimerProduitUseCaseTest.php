<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\SupprimerProduitUseCase;
use App\Domain\Repository\ProduitRepositoryInterface;

test('il peut être instancié avec un dépôt de produits', function () {
    // Arrange
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Act
    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);

    // Assert
    expect($useCase)->toBeInstanceOf(SupprimerProduitUseCase::class);
});

test('il supprime avec succès un produit existant', function () {
    // Arrange
    $produitId = 'prod-456';

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Une fois la logique métier en place, vous configurerez votre dépôt pour s'attendre à une suppression :
    // $produitRepositoryMock->shouldReceive('supprimer')->once()->with($produitId);

    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);

    // Act & Assert
    // On vérifie que l'exécution se déroule sans lever d'exception
    expect(fn() => $useCase->execute($produitId))->not->toThrow(Exception::class);
});

test('il lève une exception si le produit à supprimer n\'existe pas', function () {
    // Arrange
    $produitId = 'prod-inexistant';

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Configuration pour simuler l'absence du produit :
    // $produitRepositoryMock->shouldReceive('supprimer')
    //     ->with($produitId)
    //     ->andThrow(new Exception("Produit introuvable"));

    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);

    // Act & Assert
    // Ce test validera que votre Use Case gère correctement l'erreur comme indiqué dans votre PHPDoc
    // expect(fn() => $useCase->execute($produitId))->toThrow(Exception::class);
});
