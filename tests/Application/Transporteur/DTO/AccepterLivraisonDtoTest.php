<?php

namespace Test\Application\Transporteur\DTO;

use App\Application\Transporteur\DTO\AccepterLivraisonDto;

test('il peut être instancié avec un ID de livraison et un ID de transporteur', function () {
    // 1. Arrange (Préparation des données de test)
    $livraisonId = 'liv-12345';
    $transporteurId = 'trans-67890';

    // 2. Act (Exécution de l'action : instanciation du DTO)
    $dto = new AccepterLivraisonDto($livraisonId, $transporteurId);

    // 3. Assert (Vérifications des getters)
    expect($dto->getLivraisonId())->toBe($livraisonId)
        ->and($dto->getTransporteurId())->toBe($transporteurId);
});

test('il conserve le typage strict des chaînes de caractères', function () {
    $dto = new AccepterLivraisonDto('abc', 'def');

    expect($dto->getLivraisonId())->toBeString()
        ->and($dto->getTransporteurId())->toBeString();
});
