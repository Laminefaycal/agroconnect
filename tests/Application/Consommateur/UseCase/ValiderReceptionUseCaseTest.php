<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\ValiderReceptionUseCase;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;

test('il doit exécuter la validation de la réception sans erreur', function () {
    // Arrange
    $idLivraison = 'liv-999';
    $commandeRepository = mock(CommandeRepositoryInterface::class);
    $livraisonRepository = mock(LivraisonRepositoryInterface::class);

    $useCase = new ValiderReceptionUseCase($commandeRepository, $livraisonRepository);

    // Act & Assert
    // On vérifie simplement que l'appel s'exécute sans planter (retourne void)
    expect($useCase->execute($idLivraison))->toBeNull();
});
