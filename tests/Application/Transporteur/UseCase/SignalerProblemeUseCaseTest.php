<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\UseCase\SignalerProblemeUseCase;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Entity\Livraison;

it('signale un incident sur une livraison', function () {
    // Arrange
    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('notifierIncident')->with('Panne mécanique sur la route de Oyem')->once();
    $livraisonMock->shouldReceive('changerStatut')->with('incident_signale')->once();

    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findById')->with('LIV-001')->andReturn($livraisonMock);
    $repositoryMock->shouldReceive('save')->with($livraisonMock)->once();

    $useCase = new SignalerProblemeUseCase($repositoryMock);

    // Act
    $useCase->execute('LIV-001', 'Panne mécanique sur la route de Oyem');

    // Assert
    expect(true)->toBeTrue();
});
