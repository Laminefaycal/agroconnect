<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\SuivreLivraisonUseCase;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use App\Domain\Commande\Commande;
use App\Domain\Livraison\Livraison;

it('retourne les détails de la livraison quand la commande existe', function () {
    // 1. ARRANGEMENT
    $commandeId = 'cmd-xyz-789';

    // Création des doubles (Mocks) pour l'entité et la livraison
    $commandeMock = mock(Commande::class);
    $livraisonMock = mock(Livraison::class);

    // Mock du CommandeRepository
    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn($commandeMock);

    // Mock du LivraisonRepository
    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldReceive('findByCommandeId')
        ->once()
        ->with($commandeId)
        ->andReturn($livraisonMock);

    // 2. ACT
    $useCase = new SuivreLivraisonUseCase($commandeRepositoryMock, $livraisonRepositoryMock);
    $resultat = $useCase->execute($commandeId);

    // 3. ASSERT
    expect($resultat)->toBe($livraisonMock);
});

it('lève une exception si la commande est introuvable', function () {
    // 1. ARRANGEMENT
    $commandeId = 'cmd-inexistante';

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    // On simule qu'aucune commande n'est trouvée (renvoie null)
    $commandeRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn(null);

    // RÈGLE DE SÉCURITÉ : Le dépôt de livraison ne doit jamais être interrogé
    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldNotReceive('findByCommandeId');

    // 2. ACT & ASSERT
    $useCase = new SuivreLivraisonUseCase($commandeRepositoryMock, $livraisonRepositoryMock);

    expect(fn() => $useCase->execute($commandeId))
        ->toThrow(\Exception::class, 'Commande introuvable.');
});
