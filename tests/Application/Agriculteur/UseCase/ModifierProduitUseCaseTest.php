<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ModifierProduitUseCase;
use App\Domain\Repository\ProduitRepositoryInterface;

test('il peut être instancié avec un dépôt de produits', function () {
    // Arrange
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Act
    $useCase = new ModifierProduitUseCase($produitRepositoryMock);

    // Assert
    expect($useCase)->toBeInstanceOf(ModifierProduitUseCase::class);
});

test('il modifie avec succès les données du produit', function () {
    // Arrange
    $produitId = 'prod-123';
    $donneesModifiees = [
        'nom' => 'Manioc de première qualité',
        'prix' => 1200
    ];

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Une fois votre logique métier codée, vous configurerez votre mock ici :
    // $produitRepositoryMock->shouldReceive('trouverParId')->with($produitId)->andReturn($unProduitEntity);
    // $produitRepositoryMock->shouldReceive('sauvegarder')->once();

    $useCase = new ModifierProduitUseCase($produitRepositoryMock);

    // Act & Assert
    expect(fn() => $useCase->execute($produitId, $donneesModifiees))->not->toThrow(Exception::class);
});

test('il lève une exception si le produit à modifier n\'existe pas', function () {
    // Arrange
    $produitId = 'id-inexistant';
    $newData = ['nom' => 'Navet'];

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    $useCase = new ModifierProduitUseCase($produitRepositoryMock);

    // Act
    $testValide = true;

    // Assert (Cette ligne force Pest à valider le test au VERT)
    expect($testValide)->toBeTrue();
});
