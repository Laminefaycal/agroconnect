<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\MettreAJourStockUseCase;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Produit\Produit; // Adapte l'import selon le namespace exact de ton entité Produit

it('met à jour le stock avec succès quand le produit existe et la quantité est valide', function () {
    // 1. ARRANGEMENT (Préparation des mocks et des données)
    $produitId = 'prod-123';
    $nouvelleQuantite = 45;

    // Création du double (Mock) de l'entité Produit
    $produitMock = mock(Produit::class);
    // On s'attend à ce que setQuantite soit appelée avec la nouvelle valeur
    $produitMock->shouldReceive('setQuantite')
        ->once()
        ->with($nouvelleQuantite);

    // Création du double (Mock) du Repository
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // On simule le fait que le produit est trouvé
    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // On s'attend à ce que la méthode save soit appelée pour enregistrer les modifications
    $produitRepositoryMock->shouldReceive('save')
        ->once()
        ->with($produitMock);

    // 2. ACT (Exécution de l'action)
    $useCase = new MettreAJourStockUseCase($produitRepositoryMock);
    $useCase->execute($produitId, $nouvelleQuantite);

    // 3. ASSERT
    // Les attentes (shouldReceive) configurées sur les mocks font office d'assertions de comportement.
    expect(true)->toBeTrue();
});

it('lève une exception si le produit est introuvable', function () {
    // 1. ARRANGEMENT
    $produitId = 'prod-inexistant';

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);
    // Le repository renvoie null pour simuler un produit introuvable
    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // 2. ACT & ASSERT (Pest intercepte l'exception attendue)
    $useCase = new MettreAJourStockUseCase($produitRepositoryMock);

    expect(fn() => $useCase->execute($produitId, 10))
        ->toThrow(\Exception::class, 'Produit introuvable.');
});

it('lève une exception si la quantité fournie est négative', function () {
    // 1. ARRANGEMENT
    $produitId = 'prod-123';
    $quantiteNegative = -5;

    $produitMock = mock(Produit::class);
    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // Le repository ne devrait jamais appeler save() car le code doit bloquer avant
    $produitRepositoryMock->shouldNotReceive('save');

    // 2. ACT & ASSERT
    $useCase = new MettreAJourStockUseCase($produitRepositoryMock);

    expect(fn() => $useCase->execute($produitId, $quantiteNegative))
        ->toThrow(\InvalidArgumentException::class, 'Le stock ne peut pas être négatif.');
});
