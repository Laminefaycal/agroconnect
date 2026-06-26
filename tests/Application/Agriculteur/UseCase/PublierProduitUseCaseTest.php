<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\DTO\PublierProduitDto;
use App\Application\Agriculteur\UseCase\Exception\AgriculteurInexistantException;
use App\Application\Agriculteur\UseCase\Exception\ProduitNonSauvegardeException;
use App\Application\Agriculteur\UseCase\PublierProduitUseCase;
use App\Domain\Agriculteur\Agriculteur;
use App\Domain\Produit\Produit;
use App\Domain\Repository\AgriculteurRepositoryInterface;
use App\Domain\Repository\ProduitRepositoryInterface;
use Mockery;

beforeEach(function () {
    $this->agriculteurRepository = mock(AgriculteurRepositoryInterface::class);
    $this->produitRepository = mock(ProduitRepositoryInterface::class);
    $this->useCase = new PublierProduitUseCase(
        $this->produitRepository,
        $this->agriculteurRepository
    );
});

test('il publie un produit avec succès', function () {
    // Arrange
    $agriculteurId = 1;
    $nom = 'Carotte';
    $description = 'Carotte bio';
    $prixUnitaire = 2.5;
    $stock = 100;
    $unite = 'kg';

    $dto = new PublierProduitDto($agriculteurId, $nom, $description, $prixUnitaire, $stock, $unite);

    // Mock de l'agriculteur
    $agriculteurMock = mock(Agriculteur::class);

    $this->agriculteurRepository
        ->shouldReceive('findById')
        ->once()
        ->with($agriculteurId)
        ->andReturn($agriculteurMock);

    // Produit attendu (celui qui sera créé et retourné)
    $produitAttendu = new Produit($nom, $description, $prixUnitaire, $stock, $unite);
    $produitAttendu->setAgriculteur($agriculteurMock);

    $this->produitRepository
        ->shouldReceive('save')
        ->once()
        ->with(Mockery::on(function (Produit $produitSauvegarde) use ($nom, $description, $prixUnitaire, $stock, $unite, $agriculteurMock) {
            return $produitSauvegarde->getNom() === $nom
                && $produitSauvegarde->getDescription() === $description
                && $produitSauvegarde->getPrixUnitaire() === $prixUnitaire
                && $produitSauvegarde->getStock() === $stock
                && $produitSauvegarde->getUnite() === $unite
                && $produitSauvegarde->getAgriculteur() === $agriculteurMock;
        }))
        ->andReturn($produitAttendu);

    // Act
    $resultat = $this->useCase->execute($dto);

    // Assert
    expect($resultat)->toBe($produitAttendu)
        ->and($resultat->getAgriculteur())->toBe($agriculteurMock)
        ->and($resultat->getNom())->toBe($nom)
        ->and($resultat->getPrixUnitaire())->toBe($prixUnitaire);
});

test('il lève une exception si l\'agriculteur n\'existe pas', function () {
    // Arrange
    $agriculteurId = 999;
    $dto = new PublierProduitDto($agriculteurId, 'Nom', 'Desc', 1.0, 10, 'kg');

    $this->agriculteurRepository
        ->shouldReceive('findById')
        ->once()
        ->with($agriculteurId)
        ->andReturn(null);

    // La méthode save ne doit jamais être appelée
    $this->produitRepository->shouldReceive('save')->never();

    // Assert
    $this->expectException(AgriculteurInexistantException::class);
    $this->expectExceptionMessage("L'agriculteur avec l'identifiant '999' n'existe pas.");

    // Act
    $this->useCase->execute($dto);
});

test('il lève une exception si la sauvegarde du produit échoue', function () {
    // Arrange
    $agriculteurId = 1;
    $dto = new PublierProduitDto($agriculteurId, 'Nom', 'Desc', 1.0, 10, 'kg');

    $agriculteurMock = mock(Agriculteur::class);
    $this->agriculteurRepository
        ->shouldReceive('findById')
        ->once()
        ->with($agriculteurId)
        ->andReturn($agriculteurMock);

    $this->produitRepository
        ->shouldReceive('save')
        ->once()
        ->andReturn(null); // Échec de la sauvegarde

    // Assert
    $this->expectException(ProduitNonSauvegardeException::class);
    $this->expectExceptionMessage('Impossible de sauvegarder le produit.');

    // Act
    $this->useCase->execute($dto);
});
