<?php

namespace Test\Application\Consommateur\UseCase;


use App\Application\Consommateur\UseCase\PasserCommandeUseCase;
use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Consommateur\Repository\ConsommateurRepositoryInterface;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;
use App\Domain\Produit\Produit;
use App\Domain\Services\ServiceDisponibilite;
use InvalidArgumentException;
use Mockery;

beforeEach(function () {
    // Initialisation des mocks pour toutes les dépendances requises
    $this->commandeRepository = mock(CommandeRepositoryInterface::class);
    $this->consommateurRepository = mock(ConsommateurRepositoryInterface::class);
    $this->produitRepository = mock(ProduitRepositoryInterface::class);
    $this->serviceDisponibilite = mock(ServiceDisponibilite::class);

    // Instanciation de la classe à tester
    $this->useCase = new PasserCommandeUseCase(
        $this->commandeRepository,
        $this->consommateurRepository,
        $this->produitRepository,
        $this->serviceDisponibilite
    );
});

afterEach(function () {
    Mockery::close();
});

it('cree et persiste la commande avec succes lorsque les produits sont disponibles', function () {
    // 1. Arrange
    $lignesData = [
        ['produitId' => 'prod-100', 'quantite' => 2]
    ];

    $dto = new PasserCommandeDto(
        consommateurId: 'client-123',
        panier: $lignesData,
        adresseLivraison: '123 Rue de la République'
    );

    $dto->lignes = $lignesData;
    $dto->modeLivraison = ModeLivraison::TRANSPORTEUR;

    // Simulation du comportement du produit trouvé
    $produitMock = mock(Produit::class);
    $produitMock->shouldReceive('getPrix')->andReturn(1500.0);

    $this->serviceDisponibilite
        ->shouldReceive('verifierLignes')
        ->once()
        ->with($dto->lignes)
        ->andReturn(true);

    $this->produitRepository
        ->shouldReceive('findById')
        ->once()
        ->with('prod-100')
        ->andReturn($produitMock);

    $this->commandeRepository
        ->shouldReceive('save')
        ->once()
        ->with(Mockery::type(Commande::class));

    // 2. Act
    $commande = $this->useCase->execute($dto);

    // 3. Assert
    expect($commande)->toBeInstanceOf(Commande::class)
        ->and($commande->getId())->toStartWith('cmd-')
        ->and($commande->getStatut())->toBe(StatutCommande::EN_ATTENTE_VALIDATION);
});

it('leve une exception si certains produits ne sont pas disponibles en quantite suffisante', function () {
    // 1. Arrange
    $lignesInvalides = [
        ['produitId' => 'prod-rupture', 'quantite' => 10]
    ];

    $dto = new PasserCommandeDto(
        consommateurId: 'client-123',
        panier: $lignesInvalides,
        adresseLivraison: '123 Rue de la République'
    );

    $dto->lignes = $lignesInvalides;
    $dto->modeLivraison = ModeLivraison::AGRICULTEUR;

    $this->serviceDisponibilite
        ->shouldReceive('verifierLignes')
        ->once()
        ->with($dto->lignes)
        ->andReturn(false);

    // Le repository ne doit pas être appelé pour chercher le produit si les lignes ne sont pas dispo
    $this->produitRepository->shouldReceive('findById')->never();
    $this->commandeRepository->shouldReceive('save')->never();

    // 2. Act & Assert
    expect(fn () => $this->useCase->execute($dto))
        ->toThrow(InvalidArgumentException::class, "Certains produits demandés ne sont plus disponibles en quantité suffisante.");
});

it('leve une exception si un produit n existe pas dans le repository', function () {
    // 1. Arrange
    $lignesData = [
        ['produitId' => 'prod-inexistant', 'quantite' => 1]
    ];

    $dto = new PasserCommandeDto(
        consommateurId: 'client-123',
        panier: $lignesData,
        adresseLivraison: '123 Rue de la République'
    );

    $dto->lignes = $lignesData;
    $dto->modeLivraison = ModeLivraison::AGRICULTEUR;

    $this->serviceDisponibilite
        ->shouldReceive('verifierLignes')
        ->once()
        ->with($dto->lignes)
        ->andReturn(true);

    // Le produit renvoie null (introuvable)
    $this->produitRepository
        ->shouldReceive('findById')
        ->once()
        ->with('prod-inexistant')
        ->andReturn(null);

    $this->commandeRepository->shouldReceive('save')->never();

    // 2. Act & Assert
    expect(fn () => $this->useCase->execute($dto))
        ->toThrow(InvalidArgumentException::class, "Le produit avec l'ID prod-inexistant n'existe pas.");
});
