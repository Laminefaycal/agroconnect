<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\ValiderReceptionDto;

it('peut être instancié avec des arguments nommés et retourne les bonnes valeurs', function () {
    // Act
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-001',
        estLivree: true
    );

    // Assert
    expect($dto->getCommandeId())->toBe('CMD-001')
        ->and($dto->isEstLivree())->toBeTrue();
});

it('peut représenter une commande non livrée', function () {
    // Act
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-002',
        estLivree: false
    );

    // Assert
    expect($dto->getCommandeId())->toBe('CMD-002')
        ->and($dto->isEstLivree())->toBeFalse();
});

it('retourne les bons types de données', function () {
    // Act
    $dto = new ValiderReceptionDto('CMD-003', true);

    // Assert
    expect($dto->getCommandeId())->toBeString()
        ->and($dto->isEstLivree())->toBeBool();
});
