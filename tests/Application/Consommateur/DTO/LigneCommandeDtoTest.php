<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\LigneCommandeDto;

it('peut être instancié avec des arguments nommés et retourne les bonnes valeurs', function () {
    // Act
    $dto = new LigneCommandeDto(
        produitId: 'PROD-100',
        quantite: 5
    );

    // Assert
    expect($dto->getProduitId())->toBe('PROD-100')
        ->and($dto->getQuantite())->toBe(5);
});

it('retourne les bons types de données', function () {
    // Act
    $dto = new LigneCommandeDto('PROD-200', 12);

    // Assert
    expect($dto->getProduitId())->toBeString()
        ->and($dto->getQuantite())->toBeInt();
});

it('conserve la quantité exacte transmise', function () {
    // Act
    $dto = new LigneCommandeDto('PROD-300', 1);

    // Assert
    expect($dto->getQuantite())->toBeGreaterThan(0)
        ->and($dto->getQuantite())->toEqual(1);
});
