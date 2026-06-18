<?php

namespace Tests\Application\Agriculteur\DTO;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;

it('initialise correctement les propriétés du DTO avec un transporteur', function () {
    $dto = new ValiderCommandeDto(
        commandeId: 'CMD-12345',
        estDisponible: true,
        modeLivraison: 'LIVRAISON_DOMICILE',
        transporteurId: 'Trans-125'
    );

    expect($dto->commandeId)->toBe('CMD-12345')
        ->and($dto->estDisponible)->toBeTrue()
        ->and($dto->modeLivraison)->toBe('LIVRAISON_DOMICILE')
        ->and($dto->transporteurId)->toBeString('Trans-125');
});

it('initialise correctement les propriétés du DTO sans transporteur', function () {
    $dto = new ValiderCommandeDto(
        commandeId: 'CMD-12345',
        estDisponible: true,
        modeLivraison: 'RETRAIT_SUR_PLACE'
    );

    expect($dto->commandeId)->toBe('CMD-12345')
        ->and($dto->estDisponible)->toBeTrue()
        ->and($dto->modeLivraison)->toBe('RETRAIT_SUR_PLACE')
        ->and($dto->transporteurId)->toBeNull();
});
