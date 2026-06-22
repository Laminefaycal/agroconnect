<?php

namespace Tests\Application\Agriculteur\UseCase;
use App\Application\Agriculteur\UseCase\ModifierProduitUseCase;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;

test('il modifie et sauvegarde le produit avec succès', function () {
    // 1. Préparation (Arrange)
    $produitId = 'prod-123';
    $data = ['nom' => 'Nouvelle Pomme', 'prix' => 2.5];

    // On crée un faux produit (un objet générique pour le test)
    $produitMock = new stdClass();

    // On mocke le repository
    $produitRepository = mock(ProduitRepositoryInterface::class);

    // On s'attend à ce que findById soit appelé et retourne notre faux produit
    $produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // On s'attend à ce que save soit appelé avec ce même produit
    $produitRepository->shouldReceive('save')
        ->once()
        ->with($produitMock);

    // 2. Exécution (Act)
    $useCase = new ModifierProduitUseCase($produitRepository);
    $useCase->execute($produitId, $data);

    // 3. Affirmation (Assert)
    // Pest validera automatiquement que les méthodes du mock ont été appelées comme prévu (Mockery sous le capot)
});

test('il lève une exception si le produit n\'existe pas', function () {
    // 1. Préparation (Arrange)
    $produitId = 'prod-invalide';
    $data = ['nom' => 'Test'];

    $produitRepository = mock(ProduitRepositoryInterface::class);

    // Le repository retourne null car le produit n'existe pas
    $produitRepository->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // La méthode save ne devrait JAMAIS être appelée dans ce cas
    $produitRepository->shouldNotReceive('save');

    // 2. Exécution & Affirmation (Act & Assert)
    $useCase = new ModifierProduitUseCase($produitRepository);

    // On dit à Pest qu'on s'attend à ce qu'une Exception soit levée
    expect(fn () => $useCase->execute($produitId, $data))
        ->toThrow(\Exception::class, "Produit non trouvé.");
});
