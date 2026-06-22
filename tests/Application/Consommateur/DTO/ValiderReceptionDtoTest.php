<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\ValiderReceptionDto;

it('initialise correctement une validation de réception', function () {
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-001',
        estRecue: true
    );

    expect($dto->commandeId)->toBe('CMD-001')
        ->and($dto->estRecue)->toBeTrue();
});

it('peut représenter une commande non livrée', function () {
    $dto = new ValiderReceptionDto(
        commandeId: 'CMD-002',
        estRecue: false
    );

    expect($dto->commandeId)->toBe('CMD-002')
        ->and($dto->estRecue)->toBeFalse();
});

it('retourne les types attendus', function () {
    $dto = new ValiderReceptionDto(
        'CMD-001',
        true
    );

    expect($dto->commandeId)->toBeString()
        ->and($dto->estRecue)->toBeBool();
});
