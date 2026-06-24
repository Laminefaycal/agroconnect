<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ConsulterCommandesRecuesUseCase;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Commande\Commande;
use App\Domain\Commande\StatutCommande;

it('récupère les commandes reçues et filtre les commandes terminées', function () {
    // 1. ARRANGEMENT
    $agriculteurId = 'agri-777';

    $commandeValide = mock(Commande::class);
    $commandeValide->shouldReceive('getStatut')->andReturn(StatutCommande::VALIDEE);

    $commandeLivre = mock(Commande::class);
    $commandeLivre->shouldReceive('getStatut')->andReturn(StatutCommande::LIVREE);

    $commandeTerminee = mock(Commande::class);
    $commandeTerminee->shouldReceive('getStatut')->andReturn(StatutCommande::TERMINEE);

    $listeCommandesBrute = [$commandeValide, $commandeTerminee, $commandeLivre];

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findByAgriculteurId')
        ->once()
        ->with($agriculteurId)
        ->andReturn($listeCommandesBrute);

    // 2. ACT
    $useCase = new ConsulterCommandesRecuesUseCase($commandeRepositoryMock);
    $resultat = $useCase->execute($agriculteurId);

    // 3. ASSERT
    expect($resultat)->toBeArray()
        ->toHaveCount(2) // 💡 Passera enfin à 2 !
        ->not->toContain($commandeTerminee)
        ->toContain($commandeValide, $commandeLivre);
});
