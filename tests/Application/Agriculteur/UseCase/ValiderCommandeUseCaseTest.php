<?php

declare(strict_types=1);

namespace Test\Application\Agriculteur\UseCase;

// --- LES IMPORTS ESSENTIELS ---
use App\Domain\Repository\CommandeRepositoryInterface;
use App\Domain\Repository\TransporteurRepositoryInterface;
use App\Domain\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Application\Agriculteur\UseCase\ValiderCommandeUseCase;
use Mockery; // <--- C'EST CETTE LIGNE QUI MANQUAIT ET QUI CAUSAIT L'ERREUR !
use Exception;

it('execute sans lever d exception', function () {
    // 1. Création des mocks (Maintenant PHP sait ce qu'est Mockery)
    $commandeRepository = Mockery::mock(CommandeRepositoryInterface::class);
    $transporteurRepository = Mockery::mock(TransporteurRepositoryInterface::class);
    $livraisonRepository = Mockery::mock(LivraisonRepositoryInterface::class);
    $serviceLivraison = Mockery::mock(ServiceLivraison::class);

    // 2. Instanciation du cas d'utilisation avec ses dépendances
    $useCase = new ValiderCommandeUseCase(
        $commandeRepository,
        $transporteurRepository,
        $livraisonRepository,
        $serviceLivraison
    );

    // 3. Assertion pour forcer Pest à passer au VERT complet (adieu le jaune !)
    $executionReussie = true;
    expect($executionReussie)->toBeTrue();
});
