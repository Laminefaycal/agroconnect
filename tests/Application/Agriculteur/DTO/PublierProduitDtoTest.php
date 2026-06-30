<?php

namespace Tests\Application\Agriculteur\DTO;

use App\Application\Agriculteur\DTO\PublierProduitDto;

it('respecte les types attendus', function () {
    $dto = new PublierProduitDto(
        'id-1',
        'Tomates',
        'Tomates biologiques fraîches',
        2500.50,
        100,
        'kg'
    );

    expect($dto->agriculteurId)->toBeString()
        ->and($dto->nom)->toBeString()
        ->and($dto->description)->toBeString()
        ->and($dto->prix)->toBeFloat()
        ->and($dto->stock)->toBeInt()
        ->and($dto->unite)->toBeString();
});
