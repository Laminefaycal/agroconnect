<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\SupprimerProduitUseCase;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Produit\Produit; // Adapte l'import selon le namespace réel de ton entité Produit

it('supprime le produit avec succès s’il existe et n’a pas de commandes en cours', function () {
    // 1. ARRANGEMENT
    $produitId = 'prod-123';

    // On mock l'entité Produit
    $produitMock = mock(Produit::class);

    // RÈGLE MÉTIER : On simule que le produit N'A PAS de commandes en cours
    $produitMock->shouldReceive('aDesCommandesEnCours')
        ->once()
        ->andReturn(false);

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // On simule que le produit est trouvé
    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // On s'attend à ce que la méthode delete soit bien appelée
    $produitRepositoryMock->shouldReceive('delete')
        ->once()
        ->with($produitId);

    // 2. ACT
    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);
    $useCase->execute($produitId);

    // 3. ASSERT
    expect(true)->toBeTrue();
});

it('lève une exception si le produit à supprimer n’existe pas', function () {
    // 1. ARRANGEMENT
    $produitId = 'prod-inexistant';

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    // Le produit n'existe pas en BDD -> renvoie null
    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn(null);

    // Le repository ne doit JAMAIS appeler delete
    $produitRepositoryMock->shouldNotReceive('delete');

    // 2. ACT & ASSERT
    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);

    expect(fn() => $useCase->execute($produitId))
        ->toThrow(\Exception::class, 'Produit introuvable.');
});

it('lève une exception si le produit a des commandes en cours', function () {
    // 1. ARRANGEMENT
    $produitId = 'prod-123';

    $produitMock = mock(Produit::class);

    // RÈGLE MÉTIER : On simule que le produit A des commandes en cours
    $produitMock->shouldReceive('aDesCommandesEnCours')
        ->once()
        ->andReturn(true);

    $produitRepositoryMock = mock(ProduitRepositoryInterface::class);

    $produitRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($produitId)
        ->andReturn($produitMock);

    // PROTECTION MÉTIER : Le repository ne doit JAMAIS appeler delete si c'est bloqué
    $produitRepositoryMock->shouldNotReceive('delete');

    // 2. ACT & ASSERT
    $useCase = new SupprimerProduitUseCase($produitRepositoryMock);

    expect(fn() => $useCase->execute($produitId))
        ->toThrow(\DomainException::class, 'Impossible de supprimer ce produit.');
});
