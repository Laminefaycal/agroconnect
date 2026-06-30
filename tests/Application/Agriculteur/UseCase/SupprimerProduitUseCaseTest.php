<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\SupprimerProduitUseCase;
use App\Domain\Produit\Produit;
use App\Domain\Produit\ProduitRepositoryInterface;

test('supprime un produit existant avec succès', function () {
    // Arrange
    $produitId = 'prod-123';
    $produit = mock(Produit::class);

    $repository = mock(ProduitRepositoryInterface::class);
    $repository->shouldReceive('findById')
        ->with($produitId)
        ->once()
        ->andReturn($produit);
    $repository->shouldReceive('delete')
        ->with($produitId)
        ->once();

    $useCase = new SupprimerProduitUseCase($repository);

    // Act
    $useCase->execute($produitId);

    // Assertions implicites via les expectations Mockery
})->group('use-case', 'supprimer-produit');

test('lève une exception si le produit n\'existe pas', function () {
    // Arrange
    $produitId = 'prod-456';

    $repository = mock(ProduitRepositoryInterface::class);
    $repository->shouldReceive('findById')
        ->with($produitId)
        ->once()
        ->andReturn(null);
    $repository->shouldReceive('delete')
        ->never();

    $useCase = new SupprimerProduitUseCase($repository);

    // Act & Assert
    expect(fn () => $useCase->execute($produitId))
        ->toThrow(\Exception::class, 'Produit introuvable.');
})->group('use-case', 'supprimer-produit');
