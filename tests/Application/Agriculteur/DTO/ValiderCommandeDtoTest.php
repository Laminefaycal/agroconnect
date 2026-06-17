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

    expect($dto)
        ->agriculteurId->toBe(1)
        ->nom->toBe('Tomates Bio')
        ->description->toBe('Tomates fraîches cultivées sans pesticides')
        ->prix->toBe(2.5)
        ->stock->toBe(100)
        ->unite->toBe('kg');
});