<?php

namespace  Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\UseCase\ConfirmerLivraisonUseCase;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Entity\Livraison;

it('confirme et cloture une livraison avec succes', function () {
    // Arrange
    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('changerStatut')->with('livre')->once();

    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findById')->with('LIV-001')->andReturn($livraisonMock);
    $repositoryMock->shouldReceive('save')->with($livraisonMock)->once();

    $useCase = new ConfirmerLivraisonUseCase($repositoryMock);

    // Act
    $useCase->execute('LIV-001');

    // Assert
    expect(true)->toBeTrue();
});
