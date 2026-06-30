<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;
use App\Application\Agriculteur\UseCase\ValiderCommandeUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Services\ServiceLivraison;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;
use Mockery as m;

beforeEach(function () {
    $this->commandeRepository = m::mock(CommandeRepositoryInterface::class);
    $this->transporteurRepository = m::mock(TransporteurRepositoryInterface::class);
    $this->livraisonRepository = m::mock(LivraisonRepositoryInterface::class);
    $this->serviceLivraison = m::mock(ServiceLivraison::class);

    $this->useCase = new ValiderCommandeUseCase(
        $this->commandeRepository,
        $this->transporteurRepository,
        $this->livraisonRepository,
        $this->serviceLivraison,
    );
});

it('valide une commande avec un transporteur', function () {
    $commandeId = 'cmd-123';
    $transporteurId = 'tr-456';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getId')->once()->andReturn($commandeId);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::EN_ATTENTE_VALIDATION);
    $commande->shouldReceive('valider')->once();
    $commande->shouldReceive('choisirModeLivraison')->with(ModeLivraison::TRANSPORTEUR)->once();
    $commande->shouldReceive('assignerTransporteur')->with(m::type(Transporteur::class))->once();

    $transporteur = m::mock(Transporteur::class);

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: true,
        modeLivraison: ModeLivraison::TRANSPORTEUR,
        transporteurId: $transporteurId
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
    $this->transporteurRepository->shouldReceive('findById')->with($transporteurId)->once()->andReturn($transporteur);

    $this->commandeRepository->shouldReceive('save')->with($commande)->once();
    $this->livraisonRepository->shouldReceive('save')->with(m::type(Livraison::class))->once();

    $this->serviceLivraison->shouldReceive('affecterTransporteur')
        ->with(m::type(Livraison::class), $transporteur)
        ->once();

    $this->useCase->execute($dto);
});

it('valide une commande avec livraison par agriculteur (sans transporteur)', function () {
    $commandeId = 'cmd-123';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getId')->once()->andReturn($commandeId);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::EN_ATTENTE_VALIDATION);
    $commande->shouldReceive('valider')->once();
    $commande->shouldReceive('choisirModeLivraison')->with(ModeLivraison::AGRICULTEUR)->once();
    $commande->shouldReceive('assignerTransporteur')->never();

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: true,
        modeLivraison: ModeLivraison::AGRICULTEUR,
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
    $this->commandeRepository->shouldReceive('save')->with($commande)->once();
    $this->livraisonRepository->shouldReceive('save')->with(m::type(Livraison::class))->once();

    $this->serviceLivraison->shouldReceive('affecterTransporteur')->never();

    $this->useCase->execute($dto);
});

it('lève une exception si la commande est introuvable', function () {
    $dto = new ValiderCommandeDto(
        commandeId: 'unknown',
        estDisponible: true,
        modeLivraison: ModeLivraison::AGRICULTEUR,
    );

    $this->commandeRepository->shouldReceive('findById')->with('unknown')->once()->andReturn(null);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage("Commande 'unknown' introuvable.");

    $this->useCase->execute($dto);
});

it('lève une exception si le statut de la commande n\'est pas EN_ATTENTE_VALIDATION', function () {
    $commandeId = 'cmd-123';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::VALIDEE);

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: true,
        modeLivraison: ModeLivraison::AGRICULTEUR,
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Seules les commandes en attente de validation peuvent être validées.');

    $this->useCase->execute($dto);
});

it('lève une exception si la commande n\'est pas disponible', function () {
    $commandeId = 'cmd-123';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::EN_ATTENTE_VALIDATION);

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: false,
        modeLivraison: ModeLivraison::AGRICULTEUR,
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Seules les commandes disponibles peuvent être validées.');

    $this->useCase->execute($dto);
});

it('lève une exception si le mode est TRANSPORTEUR mais transporteurId manquant', function () {
    $commandeId = 'cmd-123';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::EN_ATTENTE_VALIDATION);

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: true,
        modeLivraison: ModeLivraison::TRANSPORTEUR,
        transporteurId: null,
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);

    $this->transporteurRepository->shouldReceive('findById')->never();

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage('Le mode TRANSPORTEUR nécessite un identifiant de transporteur.');

    $this->useCase->execute($dto);
});

it('lève une exception si le transporteur est introuvable', function () {
    $commandeId = 'cmd-123';
    $transporteurId = 'tr-unknown';
    $commande = m::mock(Commande::class);
    $commande->shouldReceive('getStatut')->once()->andReturn(StatutCommande::EN_ATTENTE_VALIDATION);

    $dto = new ValiderCommandeDto(
        commandeId: $commandeId,
        estDisponible: true,
        modeLivraison: ModeLivraison::TRANSPORTEUR,
        transporteurId: $transporteurId,
    );

    $this->commandeRepository->shouldReceive('findById')->with($commandeId)->once()->andReturn($commande);
    $this->transporteurRepository->shouldReceive('findById')->with($transporteurId)->once()->andReturn(null);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage("Transporteur '{$transporteurId}' introuvable.");

    $this->useCase->execute($dto);
});
