<?php

namespace App\Application\Agriculteur\UseCase;
use App\Application\Agriculteur\Dto\PublierProduitDto;
use App\Application\Agriculteur\UseCase\PublierProduitUseCase;
use App\Domain\Entity\Produit;
use App\Domain\Interface\Repository\AgriculteurRepositoryInterface;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;

test('il publie un produit avec succès', function () {
    // 1. Préparation (Arrange)
    $agriculteurId = 'agri-789';

    // On mocke le DTO
    $dto = mock(PublierProduitDto::class);
    $dto->shouldReceive('getAgriculteurId')->andReturn($agriculteurId);
    $dto->shouldReceive('getNom')->andReturn('Tomate Cerise');
    $dto->shouldReceive('getPrix')->andReturn(3.50);
    $dto->shouldReceive('getQuantite')->andReturn(50);

    // On mocke l'agriculteur (on simule qu'il existe)
    $agriculteurMock = new stdClass();
    $agriculteurRepository = mock(AgriculteurRepositoryInterface::class);
    $agriculteurRepository->shouldReceive('findById')
        ->once()
        ->with($agriculteurId)
        ->andReturn($agriculteurMock);

    // On mocke le repository de Produit
    $produitRepository = mock(ProduitRepositoryInterface::class);

    // On s'attend à ce que save() reçoive une instance de l'entité Produit et la retourne
    $produitRepository->shouldReceive('save')
        ->once()
        ->with(Mockery::type(Produit::class))
        ->andReturnArg(0); // Pratique : retourne le premier argument passé à la méthode

    // 2. Exécution (Act)
    $useCase = new PublierProduitUseCase($produitRepository, $agriculteurRepository);
    $resultat = $useCase->execute($dto);

    // 3. Affirmations (Assert)
    expect($resultat)->toBeInstanceOf(Produit::class);
});

test('il lève une exception si l\'agriculteur n\'existe pas', function () {
    // 1. Préparation (Arrange)
    $dto = mock(PublierProduitDto::class);
    $dto->shouldReceive('getAgriculteurId')->andReturn('agri-inconnu');

    // L'agriculteur n'est pas trouvé
    $agriculteurRepository = mock(AgriculteurRepositoryInterface::class);
    $agriculteurRepository->shouldReceive('findById')
        ->once()
        ->with('agri-inconnu')
        ->andReturn(null);

    // Le produit ne doit jamais être sauvegardé
    $produitRepository = mock(ProduitRepositoryInterface::class);
    $produitRepository->shouldNotReceive('save');

    // 2. Exécution & Affirmation (Act & Assert)
    $useCase = new PublierProduitUseCase($produitRepository, $agriculteurRepository);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(\Exception::class, "Agriculteur introuvable.");
});
