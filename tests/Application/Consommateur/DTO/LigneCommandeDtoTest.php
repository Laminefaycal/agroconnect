<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\LigneCommandeDto;

it('initialise correctement une ligne de commande', function () {
    $dto = new LigneCommandeDto(
        produitId: 'PROD-001',
        quantite: 5
    );

    expect($dto->produitId)->toBe('PROD-001')
        ->and($dto->quantite)->toBe(5);
});

it('retourne les types attendus', function () {
    $dto = new LigneCommandeDto('PROD-001', 5);

    expect($dto->produitId)->toBeString()
        ->and($dto->quantite)->toBeInt();
});
