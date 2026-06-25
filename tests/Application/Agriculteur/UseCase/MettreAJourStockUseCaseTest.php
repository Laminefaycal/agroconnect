<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\MettreAJourStockUseCase;
use App\Domain\Produit\ProduitRepositoryInterface;
use Exception;

// Note : Remplacez par le vrai FQCN de votre entité de domaine Produit
use App\Domain\Produit\Produit;

beforeEach(function () {
    // Création du mock pour le repository de produit
    $this->produitRepository = mock(ProduitRepositoryInterface::class);

    // Instanciation du Use Case avec le mock injecté
   $this->useCase = new MettreAJourStockUseCase($this->produitRepository);
});

it('met à jour le stock et sauvegarde le produit avec succès', function () {
    // Arrange
    $produitId = 'prod-123';
    $updateData = ['quantite' => 50];

    // Création d'un mock pour l'entité Produit pour intercepter l'appel à update()
  $produitMock = mock(\App\Domain\Produit\Produit::class);
    $produitMock->shouldReceive('update')
        ->once()
        ->with($updateData);

    // Configuration des attentes du repository
    $this->produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    $this->produitRepository->shouldReceive('save')
        ->once()
        ->with($produitMock);

    // Act & Assert
    $this->useCase->execute($produitId, $updateData);

    // Pest s'assure automatiquement via Mockery que toutes les attentes (shouldReceive) ont été honorées
});

it('lève une exception si le produit n\'existe pas', function () {
    // Arrange
    $produitId = 'prod-invalide';
    $updateData = ['quantite' => 10];

    // Le repository retourne null si le produit n'est pas trouvé
    $this->produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // On s'assure que save() ne sera jamais appelé dans ce scénario
    $this->produitRepository->shouldReceive('save')
        ->never();

    // Act & Assert
    expect(fn() => $this->useCase->execute($produitId, $updateData))
        ->toThrow(Exception::class, "Produit introuvable.");
});
