<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\ConfirmerLivraisonDto;
use App\Application\Transporteur\UseCase\ConfirmerLivraisonUseCase;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use RuntimeException;

it('confirms a livraison successfully when it exists', function () {
    // Arrange
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $livraison = mock(Livraison::class);

    $dto = new ConfirmerLivraisonDto('livraison-123');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    // On s'attend à ce que confirmerLivraison soit appelée
    $livraison->shouldReceive('confirmerLivraison')
        ->once();

    $livraisonRepo->shouldReceive('save')
        ->once()
        ->with($livraison);

    $useCase = new ConfirmerLivraisonUseCase($livraisonRepo);

    // Act
    $useCase->execute($dto);

    // Assertions implicites : les mocks vérifient les appels.
    expect(true)->toBeTrue();
});

it('throws an exception when livraison is not found', function () {
    // Arrange
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $dto = new ConfirmerLivraisonDto('non-existing-livraison');

    $livraisonRepo->shouldReceive('findById')
        ->with('non-existing-livraison')
        ->andReturn(null);

    $useCase = new ConfirmerLivraisonUseCase($livraisonRepo);

    // Act & Assert
    expect(fn () => $useCase->execute($dto))
        ->toThrow(
            RuntimeException::class,
            "La livraison avec l'identifiant 'non-existing-livraison' n'existe pas."
        );
});
