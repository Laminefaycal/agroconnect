<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\PasserCommandeDto;
use App\Application\Consommateur\DTO\LigneCommandeDto;

it('peut être instancié avec des arguments nommés et retourne les bonnes valeurs', function () {
    // Arrange
    $ligneMock = mock(LigneCommandeDto::class); // Crée un mock pour simuler LigneCommandeDto
    $panier = [$ligneMock];

    // Act
    $dto = new PasserCommandeDto(
        consommateurId: 'CONS-001',
        panier: $panier,
        adresseLivraison: 'Quartier Nzeng-Ayong, Libreville'
    );

    // Assert
    expect($dto->getConsommateurId())->toBe('CONS-001')
        ->and($dto->getPanier())->toBeArray()
        ->and($dto->getPanier())->toHaveCount(1)
        ->and($dto->getPanier()[0])->toBe($ligneMock)
        ->and($dto->getAdresseLivraison())->toBe('Quartier Nzeng-Ayong, Libreville');
});

it('retourne les bons types de données', function () {
    // Arrange
    $panier = []; // Un panier vide pour tester la structure

    // Act
    $dto = new PasserCommandeDto('CONS-002', $panier, 'Quartier Alibandeng, Libreville');

    // Assert
    expect($dto->getConsommateurId())->toBeString()
        ->and($dto->getPanier())->toBeArray()
        ->and($dto->getAdresseLivraison())->toBeString();
});
