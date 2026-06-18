<?php

namespace Tests\Application\Consommateur\DTO;

use App\Application\Consommateur\DTO\LigneCommandeDto;
use App\Application\Consommateur\DTO\PasserCommandeDto;

it('initialise correctement une commande', function () {
    $ligne1 = new LigneCommandeDto('PROD-001', 2);
    $ligne2 = new LigneCommandeDto('PROD-002', 4);

    $dto = new PasserCommandeDto(
        consommateurId: 'CONS-001',
        panier: [$ligne1, $ligne2],
        adresseLivraison: 'Libreville, Quartier Louis'
    );

    expect($dto->getConsommateurId())->toBe('CONS-001')
        ->and($dto->getPanier())->toHaveCount(2)
        ->and($dto->getAdresseLivraison())->toBe('Libreville, Quartier Louis');
});

it('contient les lignes de commande attendues', function () {
    $ligne = new LigneCommandeDto('PROD-001', 3);

    $dto = new PasserCommandeDto(
        'CONS-001',
        [$ligne],
        'Libreville'
    );

    expect($dto->getPanier()[0])->toBeInstanceOf(LigneCommandeDto::class)
        ->and($dto->getPanier()[0]->getProduitId())->toBe('PROD-001')
        ->and($dto->getPanier()[0]->getQuantite())->toBe(3);
});

it('retourne les types attendus', function () {
    $dto = new PasserCommandeDto(
        'CONS-001',
        [],
        'Libreville'
    );

    expect($dto->getConsommateurId())->toBeString()
        ->and($dto->getPanier())->toBeArray()
        ->and($dto->getAdresseLivraison())->toBeString();
});
