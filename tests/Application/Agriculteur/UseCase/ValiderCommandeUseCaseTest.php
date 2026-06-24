<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ValiderCommandeUseCase;
use App\Application\Agriculteur\Dto\ValiderCommandeDto;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\TransporteurRepositoryInterface;
use App\Domain\Interface\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Domain\Commande\Commande;
use App\Domain\Transporteur\Transporteur; // Adapte selon tes namespaces réels
use App\Domain\Livraison\Livraison;

it('valide la commande et planifie la livraison avec succès', function () {
    // 1. ARRANGEMENT
    $dto = mock(ValiderCommandeDto::class);
    $dto->commandeId = 'cmd-abc-123';

    // Mock de la commande
    $commandeMock = mock(Commande::class);
    $commandeMock->shouldReceive('estEnAttente')->once()->andReturn(true);
    $commandeMock->shouldReceive('valider')->once();

    // Mock du transporteur
    $transporteurMock = mock(Transporteur::class);

    // Mock de la livraison générée par le domaine
    $livraisonMock = mock(Livraison::class);

    // Mocks des Repositories et Services
    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')->once()->with($dto->commandeId)->andReturn($commandeMock);
    $commandeRepositoryMock->shouldReceive('save')->once()->with($commandeMock);

    $transporteurRepositoryMock = mock(TransporteurRepositoryInterface::class);
    $transporteurRepositoryMock->shouldReceive('trouverDisponible')->once()->andReturn($transporteurMock);

    $serviceLivraisonMock = mock(ServiceLivraison::class);
    $serviceLivraisonMock->shouldReceive('creerLivraison')
        ->once()
        ->with($commandeMock, $transporteurMock)
        ->andReturn($livraisonMock);

    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldReceive('save')->once()->with($livraisonMock);

    // 2. ACT
    $useCase = new ValiderCommandeUseCase(
        $commandeRepositoryMock,
        $transporteurRepositoryMock,
        $livraisonRepositoryMock,
        $serviceLivraisonMock
    );
    $useCase->execute($dto);

    // 3. ASSERT
    expect(true)->toBeTrue();
});

it('lève une exception si la commande est introuvable', function () {
    // 1. ARRANGEMENT
    $dto = mock(ValiderCommandeDto::class);
    $dto->commandeId = 'cmd-inexistante';

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')->once()->with($dto->commandeId)->andReturn(null);

    $transporteurRepositoryMock = mock(TransporteurRepositoryInterface::class);
    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $serviceLivraisonMock = mock(ServiceLivraison::class);

    // 2. ACT & ASSERT
    $useCase = new ValiderCommandeUseCase(
        $commandeRepositoryMock,
        $transporteurRepositoryMock,
        $livraisonRepositoryMock,
        $serviceLivraisonMock
    );

    expect(fn() => $useCase->execute($dto))
        ->toThrow(\Exception::class, 'Commande introuvable.');
});

it('lève une exception si la commande a déjà été traitée', function () {
    // 1. ARRANGEMENT
    $dto = mock(ValiderCommandeDto::class);
    $dto->commandeId = 'cmd-deja-traitee';

    $commandeMock = mock(Commande::class);
    $commandeMock->shouldReceive('estEnAttente')->once()->andReturn(false); // 💡 Déjà traitée

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')->once()->with($dto->commandeId)->andReturn($commandeMock);

    $transporteurRepositoryMock = mock(TransporteurRepositoryInterface::class);
    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $serviceLivraisonMock = mock(ServiceLivraison::class);

    // 2. ACT & ASSERT
    $useCase = new ValiderCommandeUseCase(
        $commandeRepositoryMock,
        $transporteurRepositoryMock,
        $livraisonRepositoryMock,
        $serviceLivraisonMock
    );

    expect(fn() => $useCase->execute($dto))
        ->toThrow(\DomainException::class, 'Commande déjà traitée.');
});

it('lève une exception si aucun transporteur n’est disponible', function () {
    // 1. ARRANGEMENT
    $dto = mock(ValiderCommandeDto::class);
    $dto->commandeId = 'cmd-valide';

    $commandeMock = mock(Commande::class);
    $commandeMock->shouldReceive('estEnAttente')->once()->andReturn(true);

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')->once()->with($dto->commandeId)->andReturn($commandeMock);

    $transporteurRepositoryMock = mock(TransporteurRepositoryInterface::class);
    // 💡 Aucun chauffeur libre en bdd
    $transporteurRepositoryMock->shouldReceive('trouverDisponible')->once()->andReturn(null);

    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $serviceLivraisonMock = mock(ServiceLivraison::class);

    // 2. ACT & ASSERT
    $useCase = new ValiderCommandeUseCase(
        $commandeRepositoryMock,
        $transporteurRepositoryMock,
        $livraisonRepositoryMock,
        $serviceLivraisonMock
    );

    expect(fn() => $useCase->execute($dto))
        ->toThrow(\DomainException::class, 'Aucun transporteur disponible.');
});
