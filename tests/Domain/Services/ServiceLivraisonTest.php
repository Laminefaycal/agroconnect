<?php

namespace Tests\Domain\Services;

use App\Domain\Commande\Commande;
use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Services\ServiceLivraison;
use App\Domain\Services\TransporteurNotificationInterface;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;

beforeEach(function () {
    $this->transporteurRepository = mock(TransporteurRepositoryInterface::class);
    $this->livraisonRepository = mock(LivraisonRepositoryInterface::class);
    $this->commandeRepository = mock(CommandeRepositoryInterface::class);
    $this->notificationService = mock(TransporteurNotificationInterface::class);

    $this->service = new ServiceLivraison(
        $this->transporteurRepository,
        $this->livraisonRepository,
        $this->commandeRepository,
        $this->notificationService
    );
});

it('throws an exception when no commande is found for the livraison', function () {
    $livraison = mock(Livraison::class);
    $livraisonId = 1;
    $livraison->shouldReceive('getId')->andReturn($livraisonId);

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with($livraisonId)
        ->andReturn(null);

    expect(fn () => $this->service->proposerAuxTransporteurs($livraison))
        ->toThrow(\RuntimeException::class, 'Aucune commande associée à cette livraison.');
});

it('does nothing when the livraison mode is AGRICULTEUR', function () {
    $livraison = mock(Livraison::class);
    $livraisonId = 1;
    $livraison->shouldReceive('getId')->andReturn($livraisonId);

    $commande = mock(Commande::class);
    $commande->shouldReceive('getModeLivraison')->andReturn(ModeLivraison::AGRICULTEUR);

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with($livraisonId)
        ->andReturn($commande);

    $this->transporteurRepository->shouldReceive('findAllDisponibles')->never();
    $this->livraisonRepository->shouldReceive('save')->never();
    $livraison->shouldReceive('mettreAJourStatut')->never();

    $this->service->proposerAuxTransporteurs($livraison);
});

it('proposes the livraison to available transporteurs and updates status to PROPOSEE', function () {
    $livraison = mock(Livraison::class);
    $livraisonId = 1;
    $livraison->shouldReceive('getId')->andReturn($livraisonId);

    $commande = mock(Commande::class);
    $commande->shouldReceive('getModeLivraison')->andReturn(ModeLivraison::TRANSPORTEUR);

    $transporteurs = [
        mock(Transporteur::class),
        mock(Transporteur::class),
    ];

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with($livraisonId)
        ->andReturn($commande);

    $this->transporteurRepository
        ->shouldReceive('findAllDisponibles')
        ->once()
        ->andReturn($transporteurs);

    $livraison->shouldReceive('mettreAJourStatut')
        ->with(StatutLivraison::PROPOSEE)
        ->once();

    $this->livraisonRepository
        ->shouldReceive('save')
        ->with($livraison)
        ->once();

    $this->service->proposerAuxTransporteurs($livraison);
});

it('affects a transporteur to the livraison and saves it', function () {
    $livraison = mock(Livraison::class);
    $transporteur = mock(Transporteur::class);

    $livraison->shouldReceive('assignerTransporteur')
        ->with($transporteur)
        ->once();

    $this->livraisonRepository
        ->shouldReceive('save')
        ->with($livraison)
        ->once();

    $this->service->affecterTransporteur($livraison, $transporteur);
});
