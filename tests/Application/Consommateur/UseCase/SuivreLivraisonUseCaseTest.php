<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\SuivreLivraisonUseCase;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;

test('il doit retourner les détails de suivi associés à une commande', function () {
    // Arrange
    $idCommande = 'cmd-123';
    $donneesSuiviSimulees = ['statut' => 'En cours de route', 'transporteur' => 'Chronopost'];

    $commandeRepository = mock(CommandeRepositoryInterface::class);
    $livraisonRepository = mock(LivraisonRepositoryInterface::class);

    $livraisonRepository->shouldReceive('findByCommandeId')
        ->with($idCommande)
        ->once()
        ->andReturn($donneesSuiviSimulees);

    $useCase = new SuivreLivraisonUseCase($commandeRepository, $livraisonRepository);

    // Act
    $resultat = $useCase->execute($idCommande);

    // Assert
    expect($resultat)->toBe($donneesSuiviSimulees)
        ->and($resultat['statut'])->toBe('En cours de route');
});
