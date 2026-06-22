<?php

namespace Test\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\AccepterLivraisonDto;
use App\Application\Transporteur\UseCase\AccepterLivraisonUseCase;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Repository\TransporteurRepositoryInterface;
use App\Domain\Transporteur\Service\ServiceLivraison;
use Exception;

beforeEach(function () {
    // 1. Création des mocks pour les dépendances
    $this->livraisonRepository = mock(LivraisonRepositoryInterface::class);
    $this->transporteurRepository = mock(TransporteurRepositoryInterface::class);
    $this->serviceLivraison = mock(ServiceLivraison::class); // Non utilisé directement dans execute(), mais requis par le constructeur

    // 2. Instanciation du UseCase avec ses dépendances
    $this->useCase = new AccepterLivraisonUseCase(
        $this->livraisonRepository,
        $this->transporteurRepository,
        $this->serviceLivraison
    );

    // 3. Préparation d'un DTO de test
    $this->dto = new AccepterLivraisonDto(
        livraisonId: 42,
        transporteurId: 7
    );
});

### --- Scénarios de Succès ---

it('doit assigner le transporteur et changer le statut de la livraison avec succès', function () {
    // Mock de l'entité Transporteur
    $transporteurMock = mock(stdClass::class); // Remplace stdClass par ta classe d'entité Transporteur réelle si nécessaire
    $transporteurMock->shouldReceive('getId')->once()->andReturn(7);

    // Mock de l'entité Livraison
    $livraisonMock = mock(stdClass::class); // Remplace stdClass par ta classe d'entité Livraison réelle
    $livraisonMock->shouldReceive('assignerTransporteur')->once()->with(7);
    $livraisonMock->shouldReceive('changerStatut')->once()->with('accepte');

    // Configuration des repositories pour retourner les entités
    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->with(42)
        ->andReturn($livraisonMock);

    $this->transporteurRepository
        ->shouldReceive('findById')
        ->once()
        ->with(7)
        ->andReturn($transporteurMock);

    // On s'assure que la méthode save est bien appelée avec notre livraison modifiée
    $this->livraisonRepository
        ->shouldReceive('save')
        ->once()
        ->with($livraisonMock);

    // Exécution du UseCase
    $this->useCase->execute($this->dto);
});

### --- Scénarios d'Échec / Exceptions ---

it('doit lever une exception si la livraison est introuvable', function () {
    // Le repository retourne null pour la livraison
    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->with(42)
        ->andReturn(null);

    // Le repository transporteur ne devrait jamais être appelé si la livraison n'est pas trouvée
    $this->transporteurRepository->shouldNotReceive('findById');

    // On s'attend à ce qu'une Exception soit levée
    expect(fn () => $this->useCase->execute($this->dto))
        ->toThrow(Exception::class, 'Livraison introuvable.');
});

it('doit lever une exception si le transporteur est introuvable', function () {
    // La livraison existe
    $livraisonMock = mock(stdClass::class);
    $this->livraisonRepository
        ->shouldReceive('findById')
        ->once()
        ->with(42)
        ->andReturn($livraisonMock);

    // Mais le transporteur est introuvable
    $this->transporteurRepository
        ->shouldReceive('findById')
        ->once()
        ->with(7)
        ->andReturn(null);

    // Le save ne doit jamais être appelé
    $this->livraisonRepository->shouldNotReceive('save');

    // On s'attend à ce qu'une Exception soit levée
    expect(fn () => $this->useCase->execute($this->dto))
        ->toThrow(Exception::class, 'Transporteur introuvable.');
});
