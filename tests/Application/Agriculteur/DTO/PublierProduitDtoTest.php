<?php

namespace Tests\Application\Agriculteur\DTO;

use App\Application\Agriculteur\DTO\PublierProduitDto;

it('creates PublierProduitDto with correct values', function () {
    $dto = new PublierProduitDto(
        agriculteurId: 1,
        nom: 'Tomates Bio',
        description: 'Tomates fraîches cultivées sans pesticides',
        prix: 2.5,
        stock: 100,
        unite: 'kg'
    );

    expect($dto->agriculteurId)->toBe(1)
        ->and($dto->nom)->toBe('Tomates Bio')
        ->and($dto->description)->toBe('Tomates fraîches cultivées sans pesticides')
        ->and($dto->prix)->toBe(2.5)
        ->and($dto->stock)->toBe(100)
        ->and($dto->unite)->toBe('kg');
});