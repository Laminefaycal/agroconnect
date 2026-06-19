<?php

namespace Test\Application\Transporteur\DTO;

use App\Application\Transporteur\DTO\MiseAJourStatutDto;

test('il peut être instancié avec un ID de livraison et un statut', function () {
    // 1. Arrange
    $livraisonId = 'liv-99999';
    $statut = 'en_cours'; // Peut être une chaîne ou un Enum selon votre implémentation

    // 2. Act
    $dto = new MiseAJourStatutDto($livraisonId, $statut);

    // 3. Assert
    expect($dto->getLivraisonId())->toBe($livraisonId)
        ->and($dto->getStatut())->toBe($statut);
});

test('il accepte différents types pour le statut grâce au type mixed', function () {
    // Test avec une chaîne de caractères
    $dtoString = new MiseAJourStatutDto('liv-1', 'livré');
    expect($dtoString->getStatut())->toBe('livré');

    // Test avec un entier ou un autre type (Utile en attendant l'intégration de votre Enum)
    $dtoInt = new MiseAJourStatutDto('liv-2', 3);
    expect($dtoInt->getStatut())->toBe(3);
});
