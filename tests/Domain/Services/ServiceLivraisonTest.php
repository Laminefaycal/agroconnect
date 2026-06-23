<?php

namespace Tests\Domain\Services;

use App\Domain\Services\ServiceLivraison;
use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Livraison\Livraison; // Revenir à la vraie classe pour le type-hint
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;
use App\Domain\Services\TransporteurNotificationInterface;
use RuntimeException;
use stdClass;

beforeEach(function () {
    $this->transporteurRepository = mock(TransporteurRepositoryInterface::class);
    $this->livraisonRepository = mock(LivraisonRepositoryInterface::class);
    $this->commandeRepository = mock(CommandeRepositoryInterface::class);
    $this->notificationService = mock(TransporteurNotificationInterface::class);

    $this->serviceLivraison = new ServiceLivraison(
        $this->transporteurRepository,
        $this->livraisonRepository,
        $this->commandeRepository,
        $this->notificationService
    );
});

it('lève une exception si aucune commande n\'est associée à la livraison', function () {
    // Utiliser Livraison::class pour passer le filtre du type-hint strict de la méthode
    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('getId')->andReturn('LIV-999');

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with('LIV-999')
        ->once()
        ->andReturn(null);

    // Act & Assert
    expect(fn() => $this->serviceLivraison->proposerAuxTransporteurs($livraisonMock))
        ->toThrow(RuntimeException::class, 'Aucune commande associée à cette livraison.');
});

it('ne fait rien si le mode de livraison est AGRICULTEUR', function () {
    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('getId')->andReturn('LIV-001');

    $commandeMock = mock(stdClass::class);
    $commandeMock->shouldReceive('getModeLivraison')->andReturn(ModeLivraison::AGRICULTEUR);

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with('LIV-001')
        ->once()
        ->andReturn($commandeMock);

    $livraisonMock->shouldNotReceive('mettreAJourStatut');
    $this->transporteurRepository->shouldNotReceive('findAllDisponibles');
    $this->livraisonRepository->shouldNotReceive('save');

    $this->serviceLivraison->proposerAuxTransporteurs($livraisonMock);
});

it('met à jour le statut et sauvegarde la livraison si le mode est valide', function () {
    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('getId')->andReturn('LIV-002');

    $commandeMock = mock(stdClass::class);
    $commandeMock->shouldReceive('getModeLivraison')->andReturn('AUTRE_MODE');

    $this->commandeRepository
        ->shouldReceive('findByLivraisonId')
        ->with('LIV-002')
        ->once()
        ->andReturn($commandeMock);

    $livraisonMock->shouldReceive('mettreAJourStatut')
        ->with(StatutLivraison::PROPOSEE)
        ->once();

    $this->transporteurRepository
        ->shouldReceive('findAllDisponibles')
        ->once()
        ->andReturn([]);

    $this->livraisonRepository
        ->shouldReceive('save')
        ->once();

    $this->serviceLivraison->proposerAuxTransporteurs($livraisonMock);
});

it('affecte correctement un transporteur à une livraison et la sauvegarde', function () {
    $livraisonMock = mock(Livraison::class);
    $transporteurMock = mock(Transporteur::class);

    $livraisonMock->shouldReceive('assignerTransporteur')
        ->with($transporteurMock)
        ->once();

    $this->livraisonRepository
        ->shouldReceive('save')
        ->with($livraisonMock)
        ->once();

    $this->serviceLivraison->affecterTransporteur($livraisonMock, $transporteurMock);
});
