<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\ValiderReceptionDto;

it('initialise correctement une validation de réception', function () {
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-001',
        estLivree: true
    );

    expect($dto->getCommandeId())->toBe('CMD-001')
        ->and($dto->isEstLivree())->toBeTrue();
});

it('peut représenter une commande non livrée', function () {
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-002',
        estLivree: false
    );

    expect($dto->getCommandeId())->toBe('CMD-002')
        ->and($dto->isEstLivree())->toBeFalse();
});

it('retourne les types attendus', function () {
    $dto = new ValiderReceptionDto(
        'CMD-001',
        true
    );

    expect($dto->getCommandeId())->toBeString()
        ->and($dto->isEstLivree())->toBeBool();
});
