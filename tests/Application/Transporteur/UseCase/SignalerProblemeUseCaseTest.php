<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\SignalerProblemeDto;
use App\Application\Transporteur\UseCase\SignalerProblemeUseCase;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use RuntimeException;

it('signals a problem successfully when livraison exists and is not already delivered', function () {
    // Arrange
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $livraison = mock(Livraison::class);

    $dto = new SignalerProblemeDto('livraison-123', 'Problème de route : véhicule en panne');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    $livraison->shouldReceive('getStatut')
        ->andReturn(StatutLivraison::EN_ROUTE);

    $livraison->shouldReceive('mettreAJourStatut')
        ->once()
        ->with(StatutLivraison::PROBLEME);

    $livraisonRepo->shouldReceive('save')
        ->once()
        ->with($livraison);

    $useCase = new SignalerProblemeUseCase($livraisonRepo);

    // Act
    $useCase->execute($dto);

    // Assertions implicites via les mocks
    expect(true)->toBeTrue();
});

it('throws an exception when livraison is not found', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $dto = new SignalerProblemeDto('non-existing-livraison', 'Problème quelconque');

    $livraisonRepo->shouldReceive('findById')
        ->with('non-existing-livraison')
        ->andReturn(null);

    $useCase = new SignalerProblemeUseCase($livraisonRepo);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(
            RuntimeException::class,
            "La livraison avec l'identifiant 'non-existing-livraison' n'existe pas."
        );
});

it('throws an exception when livraison is already delivered', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $livraison = mock(Livraison::class);

    $dto = new SignalerProblemeDto('livraison-123', 'Problème après livraison');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    $livraison->shouldReceive('getStatut')
        ->andReturn(StatutLivraison::LIVREE);

    // On ne s'attend pas à ce que mettreAJourStatut soit appelé
    $livraison->shouldReceive('mettreAJourStatut')->never();

    $useCase = new SignalerProblemeUseCase($livraisonRepo);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(
            RuntimeException::class,
            'Impossible de signaler un problème : la livraison est déjà marquée comme livrée.'
        );
});
