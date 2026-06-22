<?php

namespace  Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\UseCase\MettreAJourStatutLivraisonUseCase;
use App\Application\Transporteur\DTO\MiseAJourStatutDto;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Entity\Livraison;

it('met a jour le statut d une livraison avec succes', function () {
    // Arrange
    $dto = new MiseAJourStatutDto('LIV-001', 'en_cours');

    $livraisonMock = mock(Livraison::class);
    $livraisonMock->shouldReceive('changerStatut')->with('en_cours')->once();

    $repositoryMock = mock(LivraisonRepositoryInterface::class);
    $repositoryMock->shouldReceive('findById')->with('LIV-001')->andReturn($livraisonMock);
    $repositoryMock->shouldReceive('save')->with($livraisonMock)->once();

    $useCase = new MettreAJourStatutLivraisonUseCase($repositoryMock);

    // Act
    $useCase->execute($dto);

    // Assert
    expect(true)->toBeTrue();
});
