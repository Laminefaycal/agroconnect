<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\MiseAJourStatutDto;
use App\Application\Transporteur\UseCase\MettreAJourStatutLivraisonUseCase;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface; // ← bon namespace

test('mise à jour du statut avec succès', function () {
    $livraisonId = 'liv-001';
    $statutValue = StatutLivraison::PRISE_EN_CHARGE->value;

    $dto = new MiseAJourStatutDto($livraisonId, $statutValue);

    $livraison = mock(Livraison::class);
    $livraison->shouldReceive('mettreAJourStatut')
        ->once()
        ->with(StatutLivraison::PRISE_EN_CHARGE);

    $repository = mock(LivraisonRepositoryInterface::class); // ← interface correcte
    $repository->shouldReceive('findById')
        ->once()
        ->with($livraisonId)
        ->andReturn($livraison);
    $repository->shouldReceive('save')
        ->once()
        ->with($livraison)
        ->andReturn($livraison);

    $useCase = new MettreAJourStatutLivraisonUseCase($repository);
    $useCase->execute($dto);
});

test('exception si livraison introuvable', function () {
    $livraisonId = 'liv-999';
    $statutValue = StatutLivraison::LIVREE->value;

    $dto = new MiseAJourStatutDto($livraisonId, $statutValue);

    $repository = mock(LivraisonRepositoryInterface::class);
    $repository->shouldReceive('findById')
        ->once()
        ->with($livraisonId)
        ->andReturn(null);
    $repository->shouldNotReceive('save');

    $useCase = new MettreAJourStatutLivraisonUseCase($repository);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(\Exception::class, 'Livraison introuvable.');
});
