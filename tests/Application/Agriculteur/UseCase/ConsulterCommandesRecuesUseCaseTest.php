<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\UseCase\ConsulterCommandesRecuesUseCase;
use App\Domain\Repository\CommandeRepositoryInterface;

test('il peut être instancié avec un dépôt de commandes', function () {
    // Arrange
    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);

    // Act
    $useCase = new ConsulterCommandesRecuesUseCase($commandeRepositoryMock);

    // Assert
    expect($useCase)->toBeInstanceOf(ConsulterCommandesRecuesUseCase::class);
});

test("il retourne la liste des commandes reçues pour un agriculteur donné", function () {
    // Arrange
    $agriculteurId = 'agri-123';
    $commandesFactices = [
        ['id' => 'cmd-001', 'produit' => 'Manioc', 'quantite' => 50],
        ['id' => 'cmd-002', 'produit' => 'Banane Banane', 'quantite' => 100],
    ];

    // On crée le mock et on configure la méthode attendue du Repository
    $commandeRepositoryMock = mock(CommandeRepositoryInterface::class);

    // Décommentez et ajustez le nom de la méthode selon votre vraie interface de dépôt :
    // $commandeRepositoryMock->shouldReceive('recupererParAgriculteur')
    //     ->once()
    //     ->with($agriculteurId)
    //     ->andReturn($commandesFactices);

    $useCase = new ConsulterCommandesRecuesUseCase($commandeRepositoryMock);

    // Act
    $resultat = $useCase->execute($agriculteurId);

    // Assert
    expect($resultat)->toBeArray();
    // Remarque : Pour l'instant, votre code renvoie un tableau vide []
    expect($resultat)->toBeEmpty();

    // Une fois votre logique implémentée dans le Use Case, vous changerez par :
    // expect($resultat)->toHaveCount(2);
});
