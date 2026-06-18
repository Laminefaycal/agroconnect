<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\SupprimerProduitUseCase;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;

test('il supprime le produit avec succès', function () {
    // 1. Préparation (Arrange)
    $produitId = 'prod-456';
    $produitMock = new stdClass(); // Un faux produit pour simuler l'existence

    $produitRepository = mock(ProduitRepositoryInterface::class);

    // On simule que le produit existe
    $produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // On s'attend à ce que la méthode delete soit appelée avec l'ID
    $produitRepository->shouldReceive('delete')
        ->once()
        ->with($produitId);

    // 2. Exécution (Act)
    $useCase = new SupprimerProduitUseCase($produitRepository);
    $useCase->execute($produitId);

    // 3. Affirmation (Assert)
    // Les attentes sur les mocks sont vérifiées automatiquement par Pest
});

test('il lève une exception si le produit à supprimer n\'existe pas', function () {
    // 1. Préparation (Arrange)
    $produitId = 'prod-inexistant';

    $produitRepository = mock(ProduitRepositoryInterface::class);

    // findById retourne null car le produit n'existe pas
    $produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // La méthode delete ne doit JAMAIS être appelée si le produit n'est pas trouvé
    $produitRepository->shouldNotReceive('delete');

    // 2. Exécution & Affirmation (Act & Assert)
    $useCase = new SupprimerProduitUseCase($produitRepository);

    expect(fn () => $useCase->execute($produitId))
        ->toThrow(\Exception::class, "Produit introuvable.");
});
