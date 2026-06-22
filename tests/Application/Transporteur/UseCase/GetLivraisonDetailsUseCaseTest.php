<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\UseCase\GetLivraisonDetailsUseCase;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Entity\Livraison;
use Exception; // Ajouté ici pour corriger le bug de l'exception

it('retourne les details complets d une livraison existante', function () {
    // Arrange
    $livraisonMock = mock(Livraison::class);

    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findById')
        ->with('LIV-001')
        ->once()
        ->andReturn($livraisonMock);

    $useCase = new GetLivraisonDetailsUseCase($repositoryMock);

    // Act
    $resultat = $useCase->execute('LIV-001');

    // Assert
    expect($resultat)->toBeInstanceOf(Livraison::class);
});

it('leve une exception si la livraison n existe pas', function () {
    // Arrange
    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findById')
        ->with('LIV-INVALIDE')
        ->once()
        ->andReturn(null);

    $useCase = new GetLivraisonDetailsUseCase($repositoryMock);

    // Act & Assert
    expect(fn() => $useCase->execute('LIV-INVALIDE'))
        ->toThrow(Exception::class, "Livraison non trouvée.");
});
