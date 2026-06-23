<?php

namespace Tests\Application\Agriculteur\DTO;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;
use App\Domain\Commande\ModeLivraison;

test('il peut être instancié avec tous les paramètres', function () {
    $dto = new ValiderCommandeDto(
        commandeId: 'cmd-123',
        estDisponible: true,
        modeLivraison: ModeLivraison::TRANSPORTEUR,
        transporteurId: 'tr-456'
    );

    expect($dto->commandeId)->toBe('cmd-123');
    expect($dto->estDisponible)->toBeTrue();
    expect($dto->modeLivraison)->toBe(ModeLivraison::TRANSPORTEUR);
    expect($dto->transporteurId)->toBe('tr-456');
});

test('il peut être instancié sans identifiant de transporteur', function () {
    $dto = new ValiderCommandeDto(
        commandeId: 'cmd-789',
        estDisponible: false,
        modeLivraison: ModeLivraison::AGRICULTEUR
    );

    expect($dto->commandeId)->toBe('cmd-789');
    expect($dto->estDisponible)->toBeFalse();
    expect($dto->modeLivraison)->toBe(ModeLivraison::AGRICULTEUR);
    expect($dto->transporteurId)->toBeNull();
});

test('il accepte les différentes valeurs de l\'enum ModeLivraison', function () {
    $dto1 = new ValiderCommandeDto('1', true, ModeLivraison::TRANSPORTEUR);
    expect($dto1->modeLivraison)->toBe(ModeLivraison::TRANSPORTEUR);

    $dto2 = new ValiderCommandeDto('2', false, ModeLivraison::AGRICULTEUR);
    expect($dto2->modeLivraison)->toBe(ModeLivraison::AGRICULTEUR);
});

test('les propriétés sont correctement typées', function () {
    $dto = new ValiderCommandeDto('cmd-abc', true, ModeLivraison::TRANSPORTEUR, 'tr-xyz');

    expect($dto->commandeId)->toBeString();
    expect($dto->estDisponible)->toBeBool();
    expect($dto->modeLivraison)->toBeInstanceOf(ModeLivraison::class);
    expect($dto->transporteurId)->toBeString(); // ou null, mais ici on a passé une chaîne
});
