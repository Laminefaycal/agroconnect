<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\MettreAJourStockUseCase;
use App\Domain\Produit\Produit;
use App\Domain\Produit\ProduitRepositoryInterface;
use Mockery as m;

beforeEach(function () {
    $this->produitRepository = m::mock(ProduitRepositoryInterface::class);
    $this->useCase = new MettreAJourStockUseCase($this->produitRepository);
});

it('met à jour le stock d’un produit existant', function () {
    $produitId = 'prod-123';
    $nouvelleQuantite = 50;

    $produit = m::mock(Produit::class);
    $produit->shouldReceive('setStock')->with($nouvelleQuantite)->once();

    $this->produitRepository->shouldReceive('findById')
        ->with($produitId)
        ->once()
        ->andReturn($produit);

    $this->produitRepository->shouldReceive('save')
        ->with($produit)
        ->once();

    $this->useCase->execute($produitId, $nouvelleQuantite);
});

it('lève une exception si le produit n’existe pas', function () {
    $produitId = 'unknown';
    $nouvelleQuantite = 10;

    $this->produitRepository->shouldReceive('findById')
        ->with($produitId)
        ->once()
        ->andReturn(null);

    $this->expectException(\InvalidArgumentException::class);
    $this->expectExceptionMessage("Produit 'unknown' introuvable.");

    $this->useCase->execute($produitId, $nouvelleQuantite);
});
