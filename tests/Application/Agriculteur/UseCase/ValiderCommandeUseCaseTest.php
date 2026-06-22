<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\Dto\ValiderCommandeDto;
use App\Application\Agriculteur\UseCase\ValiderCommandeUseCase;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\LivraisonRepositoryInterface;
use App\Domain\Interface\Repository\TransporteurRepositoryInterface;
use App\Domain\Service\ServiceLivraison;

test('il valide la commande et planifie la livraison avec succès', function () {
    // 1. Préparation (Arrange)
    $commandeId = 'cmd-123';
    $transporteurId = 'trans-456';

    // Mock du DTO
    $dto = mock(ValiderCommandeDto::class);
    $dto->shouldReceive('getCommandeId')->andReturn($commandeId);
    $dto->shouldReceive('getTransporteurId')->andReturn($transporteurId);

    // Mock de l'entité Commande (on s'attend à ce que valider() soit appelée)
    $commandeMock = mock('alias:App\Domain\Entity\Commande'); // Ou utilisez simplement une classe mockée classique selon votre structure
    $commandeMock->shouldReceive('valider')->once();

    // Mock du résultat de la livraison
    $livraisonMock = new stdClass();

    // Mocks des dépendances
    $commandeRepository = mock(CommandeRepositoryInterface::class);
    $transporteurRepository = mock(TransporteurRepositoryInterface::class);
    $livraisonRepository = mock(LivraisonRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    // Définition des comportements attendus
    $commandeRepository->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn($commandeMock);

    $commandeRepository->shouldReceive('save')
        ->once()
        ->with($commandeMock);

    $serviceLivraison->shouldReceive('planifier')
        ->once()
        ->with($commandeMock, $transporteurId)
        ->andReturn($livraisonMock);

    $livraisonRepository->shouldReceive('save')
        ->once()
        ->with($livraisonMock);

    // 2. Exécution (Act)
    $useCase = new ValiderCommandeUseCase(
        $commandeRepository,
        $transporteurRepository,
        $livraisonRepository,
        $serviceLivraison
    );

    $useCase->execute($dto);

    // 3. Affirmation (Assert)
    // Gérée automatiquement via les attentes (.once()) des mocks
});

test('il lève une exception si la commande n\'existe pas', function () {
    // 1. Préparation (Arrange)
    $commandeId = 'cmd-introuvable';

    $dto = mock(ValiderCommandeDto::class);
    $dto->shouldReceive('getCommandeId')->andReturn($commandeId);

    $commandeRepository = mock(CommandeRepositoryInterface::class);
    $transporteurRepository = mock(TransporteurRepositoryInterface::class);
    $livraisonRepository = mock(LivraisonRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    // La commande n'est pas trouvée
    $commandeRepository->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn(null);

    // Rien d'autre ne doit être appelé
    $commandeRepository->shouldNotReceive('save');
    $serviceLivraison->shouldNotReceive('planifier');
    $livraisonRepository->shouldNotReceive('save');

    // 2. Exécution & Affirmation (Act & Assert)
    $useCase = new ValiderCommandeUseCase(
        $commandeRepository,
        $transporteurRepository,
        $livraisonRepository,
        $serviceLivraison
    );

    expect(fn () => $useCase->execute($dto))
        ->toThrow(\Exception::class, "Commande introuvable.");
});
