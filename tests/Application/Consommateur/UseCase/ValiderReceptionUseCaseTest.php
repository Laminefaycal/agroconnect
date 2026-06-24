<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\UseCase\ValiderReceptionUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use Mockery;

beforeEach(function () {
    $this->commandeRepository = Mockery::mock(CommandeRepositoryInterface::class);
    $this->livraisonRepository = Mockery::mock(LivraisonRepositoryInterface::class);

    $this->useCase = new ValiderReceptionUseCase(
        $this->commandeRepository,
        $this->livraisonRepository
    );
});

it('lève une exception si la livraison est introuvable', function () {

    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->with('liv-1')
        ->andReturn(null);

    expect(fn () => $this->useCase->execute('liv-1'))
        ->toThrow(\Exception::class, "Livraison introuvable");
});

it('lève une exception si la commande est introuvable', function () {

    $livraison = Mockery::mock(Livraison::class);
    $livraison->shouldReceive('getCommandeId')
        ->andReturn('cmd-1');

    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->andReturn($livraison);

    $this->commandeRepository
        ->shouldReceive('findById')
        ->once()
        ->with('cmd-1')
        ->andReturn(null);

    expect(fn () => $this->useCase->execute('liv-1'))
        ->toThrow(\Exception::class, "Commande introuvable");
});

it('valide correctement la réception et sauvegarde les entités', function () {

    $livraison = Mockery::mock(Livraison::class);
    $livraison->shouldReceive('getCommandeId')->andReturn('cmd-1');
    $livraison->shouldReceive('confirmerReception')->once();

    $commande = Mockery::mock(Commande::class);
    $commande->shouldReceive('confirmerReception')->once();

    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->andReturn($livraison);

    $this->commandeRepository
        ->shouldReceive('findById')
        ->once()
        ->andReturn($commande);

    $this->livraisonRepository
        ->shouldReceive('save')
        ->once()
        ->with($livraison);

    $this->commandeRepository
        ->shouldReceive('save')
        ->once()
        ->with($commande);

    $this->useCase->execute('liv-1');

    expect(true)->toBeTrue(); // test passe si aucune exception
});
