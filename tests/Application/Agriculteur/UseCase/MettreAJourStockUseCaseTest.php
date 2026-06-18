<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\MettreAJourStockUseCase;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;

test('il met à jour le stock avec succès quand le produit existe', function () {
    // 1. Arrange (Préparation des mocks et des données)
    $produitId = 'prod-123';
    $nouvelleQuantite = 50;

    // On crée un mock de l'entité Produit (on suppose qu'elle a une méthode setQuantite)
    $produitMock = mock(stdClass::class); // Remplace stdClass par ton entité Produit réelle si nécessaire
    $produitMock->shouldReceive('setQuantite')
        ->once()
        ->with($nouvelleQuantite);

    // On crée le mock du repository
    $repositoryMock = mock(ProduitRepositoryInterface::class);

    $repositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    $repositoryMock->shouldReceive('save')
        ->once()
        ->with($produitMock);

    // 2. Act (Exécution de la méthode)
    $useCase = new MettreAJourStockUseCase($repositoryMock);
    $useCase->execute($produitId, $nouvelleQuantite);

    // 3. Assert
    // Pest s'assure automatiquement via Mockery que toutes les méthodes attendues (once) ont bien été appelées.
    expect(true)->toBeTrue();
});

test('il lève une exception si le produit n\'existe pas', function () {
    // 1. Arrange
    $produitId = 'prod-inconnu';
    $quantite = 10;

    $repositoryMock = mock(ProduitRepositoryInterface::class);

    // Le repository retourne null car le produit n'existe pas
    $repositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // Le save ne devrait jamais être appelé
    $repositoryMock->shouldNotReceive('save');

    // 2. Act & Assert (Pest permet d'attendre une exception avant l'exécution)
    $useCase = new MettreAJourStockUseCase($repositoryMock);

    expect(fn() => $useCase->execute($produitId, $quantite))
        ->toThrow(\Exception::class, "Produit introuvable pour la mise à jour du stock.");
});
