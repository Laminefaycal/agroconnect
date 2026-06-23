<?php

namespace Tests\Application\Agriculteur\DTO;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;

it('peut être instancié correctement avec toutes ses valeurs', function () {
    // 1. Arrange & Act
    $dto = new ValiderCommandeDto(
        commandeId: 'CMD-456',
        estDisponible: true,
        modeLivraison: 'TRANSPORTEUR_PLATEFORME',
        transporteurId: 'TRANS-77'
    );

    // 2. Assert
    expect($dto->commandeId)->toBe('CMD-456')
        ->and($dto->estDisponible)->toBeTrue()
        ->and($dto->modeLivraison)->toBe('TRANSPORTEUR_PLATEFORME')
        ->and($dto->transporteurId)->toBe('TRANS-77');
});

it('initialise le transporteur id à null par défaut si non fourni', function () {
    // 1. Arrange & Act
    $dto = new ValiderCommandeDto(
        commandeId: 'CMD-456',
        estDisponible: false,
        modeLivraison: 'AGRICULTEUR'
    );

    // 2. Assert
    expect($dto->commandeId)->toBe('CMD-456')
        ->and($dto->estDisponible)->toBeFalse()
        ->and($dto->modeLivraison)->toBe('AGRICULTEUR')
        ->and($dto->transporteurId)->toBeNull(); // Vérifie que la valeur par défaut est bien null
});
