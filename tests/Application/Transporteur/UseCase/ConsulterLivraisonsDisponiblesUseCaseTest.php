<?php

namespace  Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\UseCase\ConsulterLivraisonsDisponiblesUseCase;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;

it('retourne la liste des livraisons disponibles', function () {
    // Arrange
    $livraisonsSimulees = [['id' => 'LIV-001'], ['id' => 'LIV-002']];

    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findDisponibles')
        ->once()
        ->andReturn($livraisonsSimulees);

    $useCase = new ConsulterLivraisonsDisponiblesUseCase($repositoryMock);

    // Act
    $resultat = $useCase->execute();

    // Assert
    expect($resultat)->toBeArray()
        ->toHaveCount(2)
        ->and($resultat[0]['id'])->toBe('LIV-001');
});
