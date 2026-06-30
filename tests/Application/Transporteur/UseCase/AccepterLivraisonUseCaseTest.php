<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\AccepterLivraisonDto;
use App\Application\Transporteur\UseCase\AccepterLivraisonUseCase;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Services\ServiceLivraison;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;
use RuntimeException;

it('throws an exception when livraison is not found', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $transporteurRepo = mock(TransporteurRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    $dto = new AccepterLivraisonDto('non-existing-livraison', 'transporteur-123');

    $livraisonRepo->shouldReceive('findById')
        ->with('non-existing-livraison')
        ->andReturn(null);

    $useCase = new AccepterLivraisonUseCase($livraisonRepo, $transporteurRepo, $serviceLivraison);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(RuntimeException::class, "La livraison avec l'identifiant 'non-existing-livraison' n'existe pas.");
});

it('throws an exception when transporteur is not found', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $transporteurRepo = mock(TransporteurRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    $livraison = mock(Livraison::class);
    $dto = new AccepterLivraisonDto('livraison-123', 'non-existing-transporteur');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    $transporteurRepo->shouldReceive('findById')
        ->with('non-existing-transporteur')
        ->andReturn(null);

    $useCase = new AccepterLivraisonUseCase($livraisonRepo, $transporteurRepo, $serviceLivraison);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(RuntimeException::class, "Le transporteur avec l'identifiant 'non-existing-transporteur' n'existe pas.");
});

it('throws an exception when livraison is not in PROPOSEE status', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $transporteurRepo = mock(TransporteurRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    $livraison = mock(Livraison::class);
    $livraison->shouldReceive('getStatut')
        ->andReturn(StatutLivraison::ASSIGNEE);

    $transporteur = mock(Transporteur::class);
    $dto = new AccepterLivraisonDto('livraison-123', 'transporteur-456');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    $transporteurRepo->shouldReceive('findById')
        ->with('transporteur-456')
        ->andReturn($transporteur);

    $useCase = new AccepterLivraisonUseCase($livraisonRepo, $transporteurRepo, $serviceLivraison);

    expect(fn () => $useCase->execute($dto))
        ->toThrow(
            RuntimeException::class,
            "La livraison n'est pas proposée aux transporteurs (statut actuel : ASSIGNEE)."
        );
});

it('successfully accepts a livraison when all conditions are met', function () {
    $livraisonRepo = mock(LivraisonRepositoryInterface::class);
    $transporteurRepo = mock(TransporteurRepositoryInterface::class);
    $serviceLivraison = mock(ServiceLivraison::class);

    $livraison = mock(Livraison::class);
    $livraison->shouldReceive('getStatut')
        ->andReturn(StatutLivraison::PROPOSEE);

    $transporteur = mock(Transporteur::class);
    $dto = new AccepterLivraisonDto('livraison-123', 'transporteur-456');

    $livraisonRepo->shouldReceive('findById')
        ->with('livraison-123')
        ->andReturn($livraison);

    $transporteurRepo->shouldReceive('findById')
        ->with('transporteur-456')
        ->andReturn($transporteur);

    $serviceLivraison->shouldReceive('affecterTransporteur')
        ->once()
        ->with($livraison, $transporteur);

    $useCase = new AccepterLivraisonUseCase($livraisonRepo, $transporteurRepo, $serviceLivraison);

    $useCase->execute($dto);

    // Le test passe si aucune exception n'est levée et que le mock a bien été appelé.
    expect(true)->toBeTrue();
});
