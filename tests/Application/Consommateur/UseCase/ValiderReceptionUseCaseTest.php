<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\ValiderReceptionDto;
use App\Application\Consommateur\UseCase\ValiderReceptionUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;

it('valide la réception de la livraison avec succès', function () {
    // 1. ARRANGEMENT
    $commandeId = 'cmd-123';

    $dtoMock = mock(ValiderReceptionDto::class);
    $dtoMock->shouldReceive('getCommandeId')->andReturn($commandeId);

    $commandeMock = mock(Commande::class);

    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('confirmerReception')->once();

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn($commandeMock);

    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldReceive('findByCommandeId')
        ->once()
        ->with($commandeId)
        ->andReturn($livraisonMock);

    $livraisonRepositoryMock->shouldReceive('save')
        ->once()
        ->with($livraisonMock);

    // 2. ACT
    $useCase = new ValiderReceptionUseCase($commandeRepositoryMock, $livraisonRepositoryMock);
    $useCase->execute($dtoMock);

    // 3. ASSERT
    expect(true)->toBeTrue();
});

it('lève une exception si la commande est introuvable', function () {
    // 1. ARRANGEMENT
    $commandeId = 'cmd-introuvable';

    $dtoMock = mock(ValiderReceptionDto::class);
    $dtoMock->shouldReceive('getCommandeId')->andReturn($commandeId);

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn(null);

    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldNotReceive('findByCommandeId');

    // 2. ACT & ASSERT
    $useCase = new ValiderReceptionUseCase($commandeRepositoryMock, $livraisonRepositoryMock);

    expect(fn () => $useCase->execute($dtoMock))
        ->toThrow(\Exception::class, 'Commande introuvable.');
});

it('lève une exception si la livraison associée à la commande est introuvable', function () {
    // 1. ARRANGEMENT
    $commandeId = 'cmd-sans-livraison';

    $dtoMock = mock(ValiderReceptionDto::class);
    $dtoMock->shouldReceive('getCommandeId')->andReturn($commandeId);

    $commandeMock = mock(Commande::class);

    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);
    $commandeRepositoryMock->shouldReceive('findById')
        ->once()
        ->with($commandeId)
        ->andReturn($commandeMock);

    $livraisonRepositoryMock = mock(LivraisonRepositoryInterface::class);
    $livraisonRepositoryMock->shouldReceive('findByCommandeId')
        ->once()
        ->with($commandeId)
        ->andReturn(null);

    $livraisonRepositoryMock->shouldNotReceive('save');

    // 2. ACT & ASSERT
    $useCase = new ValiderReceptionUseCase($commandeRepositoryMock, $livraisonRepositoryMock);

    expect(fn () => $useCase->execute($dtoMock))
        ->toThrow(\Exception::class, 'Livraison introuvable.');
});
