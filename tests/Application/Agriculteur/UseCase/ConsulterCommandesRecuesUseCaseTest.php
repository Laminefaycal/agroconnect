<?php

namespace Tests\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ConsulterCommandesRecuesUseCase;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;

test('il doit retourner la liste des commandes reçues pour un agriculteur donné', function () {
    // 1. Préparation (Arrange)
    $agriculteurId = 'agri-uuid-1234';

    // Un faux tableau de commandes pour simuler le retour de la base de données
    $commandesSimulees = [
        ['id' => 'commande-1', 'produit' => 'Tomates', 'quantite' => 50],
        ['id' => 'commande-2', 'produit' => 'Pommes de terre', 'quantite' => 100],
    ];

    // Création du mock pour l'interface du Repository
    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);

    // On s'attend à ce que findByAgriculteurId soit appelé une fois avec le bon ID
    // et qu'il retourne nos commandes simulées
    $commandeRepositoryMock
        ->shouldReceive('findByAgriculteurId')
        ->once()
        ->with($agriculteurId)
        ->andReturn($commandesSimulees);

    // Instanciation du Use Case avec le mock injecté
    $useCase = new ConsulterCommandesRecuesUseCase($commandeRepositoryMock);

    // 2. Exécution (Act)
    $resultat = $useCase->execute($agriculteurId);

    // 3. Affirmations (Assert)
    expect($resultat)
        ->toBeArray()
        ->toHaveCount(2)
        ->toEqual($commandesSimulees);
});
