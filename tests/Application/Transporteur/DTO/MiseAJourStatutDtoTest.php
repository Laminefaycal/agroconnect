<?php

namespace Test\Application\Transporteur\DTO;

use App\Application\Transporteur\DTO\MiseAJourStatutDto;
use App\Domain\Livraison\StatutLivraison;
use InvalidArgumentException;

test('le DTO stocke l’ID de livraison', function () {
    $dto = new MiseAJourStatutDto('liv-123', 'EN_ROUTE');
    expect($dto->getLivraisonId())->toBe('liv-123');
});

test('le DTO convertit un statut valide en enum', function () {
    $dto = new MiseAJourStatutDto('liv-123', 'EN_ROUTE');
    expect($dto->getStatutEnum())->toBe(StatutLivraison::EN_ROUTE);
});

test('le DTO lève une exception pour un statut invalide', function () {
    $dto = new MiseAJourStatutDto('liv-123', 'STATUT_INCONNU');
    $dto->getStatutEnum();
})->throws(InvalidArgumentException::class, 'Statut invalide : STATUT_INCONNU');
