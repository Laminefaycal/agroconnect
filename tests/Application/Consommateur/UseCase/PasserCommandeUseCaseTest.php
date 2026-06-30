<?php

namespace Tests\Application\Consommateur\UseCase;

use App\Application\Consommateur\DTO\LigneCommandeDto;
use App\Application\Consommateur\DTO\PasserCommandeDto;
use App\Application\Consommateur\UseCase\PasserCommandeUseCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Consommateur\Consommateur;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\ConsommateurRepositoryInterface;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Produit\Produit;
use App\Domain\Service\ServiceDisponibilite;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

describe('PasserCommandeUseCase', function () {

    it('crée une commande avec succès dans le cas nominal', function () {
        $consommateurId = 'cons-123';
        $produitId = 'prod-456';
        $quantite = 5;
        $prix = 10.5;
        $mode = ModeLivraison::TRANSPORTEUR;

        // Mock du Consommateur
        $consommateur = Mockery::mock(Consommateur::class);
        $consommateur->shouldReceive('getId')->andReturn($consommateurId);

        // Mock du Produit
        $produit = Mockery::mock(Produit::class);
        $produit->shouldReceive('getId')->andReturn($produitId);
        $produit->shouldReceive('getNom')->andReturn('Banane');
        $produit->shouldReceive('getPrixUnitaire')->andReturn($prix);
        $produit->shouldReceive('estDisponible')->with($quantite)->andReturn(true);
        $produit->shouldReceive('decrementerStock')->with($quantite)->once();

        // Mock du LigneCommandeDto (pour éviter l'accès à une propriété privée)
        $ligneDto = Mockery::mock(LigneCommandeDto::class);
        $ligneDto->shouldReceive('getProduitId')->andReturn($produitId);
        $ligneDto->shouldReceive('getQuantite')->andReturn($quantite);

        // Repositories
        $consommateurRepo = Mockery::mock(ConsommateurRepositoryInterface::class);
        $consommateurRepo->shouldReceive('findById')->with($consommateurId)->andReturn($consommateur);

        $produitRepo = Mockery::mock(ProduitRepositoryInterface::class);
        $produitRepo->shouldReceive('findById')->with($produitId)->andReturn($produit);
        $produitRepo->shouldReceive('save')->with($produit)->once();

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $commandeRepo->shouldReceive('save')->with(Mockery::type(Commande::class))->once()->andReturnUsing(function ($commande) {
            // Simule l'assignation d'un ID par le repo
            (fn () => $this->id = 'cmd-789')->call($commande);

            return $commande;
        });

        $serviceDispo = Mockery::mock(ServiceDisponibilite::class);
        $serviceDispo->shouldReceive('verifierStock')->with($produit, $quantite)->andReturn(true);

        $useCase = new PasserCommandeUseCase(
            $commandeRepo,
            $consommateurRepo,
            $produitRepo,
            $serviceDispo
        );

        $dto = new PasserCommandeDto(
            consommateurId: $consommateurId,
            panier: [$ligneDto],
            adresseLivraison: 'Libreville, Gabon',
            modeLivraison: $mode
        );

        $commande = $useCase->execute($dto);

        expect($commande)->toBeInstanceOf(Commande::class)
            ->and($commande->getId())->toBe('cmd-789')
            ->and($commande->getStatut())->toBe(StatutCommande::EN_ATTENTE_VALIDATION)
            ->and($commande->getModeLivraison())->toBe($mode)
            ->and($commande->getLignes())->toHaveCount(1);
    });

    it('lève une exception si le consommateur est introuvable', function () {
        $consommateurId = 'cons-123';
        $ligneDto = Mockery::mock(LigneCommandeDto::class);
        $ligneDto->shouldReceive('getProduitId')->andReturn('prod-456');
        $ligneDto->shouldReceive('getQuantite')->andReturn(1);

        $consommateurRepo = Mockery::mock(ConsommateurRepositoryInterface::class);
        $consommateurRepo->shouldReceive('findById')->with($consommateurId)->andReturn(null);

        $produitRepo = Mockery::mock(ProduitRepositoryInterface::class);
        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $serviceDispo = Mockery::mock(ServiceDisponibilite::class);

        $useCase = new PasserCommandeUseCase(
            $commandeRepo,
            $consommateurRepo,
            $produitRepo,
            $serviceDispo
        );

        $dto = new PasserCommandeDto(
            consommateurId: $consommateurId,
            panier: [$ligneDto],
            adresseLivraison: 'Libreville'
        );

        expect(fn () => $useCase->execute($dto))
            ->toThrow(Exception::class, 'Consommateur introuvable.');
    });

    it('lève une exception si un produit est introuvable', function () {
        $consommateurId = 'cons-123';
        $produitId = 'prod-456';
        $ligneDto = Mockery::mock(LigneCommandeDto::class);
        $ligneDto->shouldReceive('getProduitId')->andReturn($produitId);
        $ligneDto->shouldReceive('getQuantite')->andReturn(1);

        $consommateur = Mockery::mock(Consommateur::class);
        $consommateur->shouldReceive('getId')->andReturn($consommateurId);

        $consommateurRepo = Mockery::mock(ConsommateurRepositoryInterface::class);
        $consommateurRepo->shouldReceive('findById')->with($consommateurId)->andReturn($consommateur);

        $produitRepo = Mockery::mock(ProduitRepositoryInterface::class);
        $produitRepo->shouldReceive('findById')->with($produitId)->andReturn(null);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);
        $serviceDispo = Mockery::mock(ServiceDisponibilite::class);

        $useCase = new PasserCommandeUseCase(
            $commandeRepo,
            $consommateurRepo,
            $produitRepo,
            $serviceDispo
        );

        $dto = new PasserCommandeDto(
            consommateurId: $consommateurId,
            panier: [$ligneDto],
            adresseLivraison: 'Libreville'
        );

        expect(fn () => $useCase->execute($dto))
            ->toThrow(Exception::class, 'Produit introuvable : '.$produitId);
    });

    it('lève une exception si le stock est insuffisant', function () {
        $consommateurId = 'cons-123';
        $produitId = 'prod-456';
        $quantite = 10;

        $ligneDto = Mockery::mock(LigneCommandeDto::class);
        $ligneDto->shouldReceive('getProduitId')->andReturn($produitId);
        $ligneDto->shouldReceive('getQuantite')->andReturn($quantite);

        $consommateur = Mockery::mock(Consommateur::class);
        $consommateur->shouldReceive('getId')->andReturn($consommateurId);

        $produit = Mockery::mock(Produit::class);
        $produit->shouldReceive('getNom')->andReturn('Manioc');

        $consommateurRepo = Mockery::mock(ConsommateurRepositoryInterface::class);
        $consommateurRepo->shouldReceive('findById')->with($consommateurId)->andReturn($consommateur);

        $produitRepo = Mockery::mock(ProduitRepositoryInterface::class);
        $produitRepo->shouldReceive('findById')->with($produitId)->andReturn($produit);

        $serviceDispo = Mockery::mock(ServiceDisponibilite::class);
        $serviceDispo->shouldReceive('verifierStock')->with($produit, $quantite)->andReturn(false);

        $commandeRepo = Mockery::mock(CommandeRepositoryInterface::class);

        $useCase = new PasserCommandeUseCase(
            $commandeRepo,
            $consommateurRepo,
            $produitRepo,
            $serviceDispo
        );

        $dto = new PasserCommandeDto(
            consommateurId: $consommateurId,
            panier: [$ligneDto],
            adresseLivraison: 'Libreville'
        );

        expect(fn () => $useCase->execute($dto))
            ->toThrow(Exception::class, 'Stock insuffisant pour le produit : Manioc');
    });
});
