<?php

namespace Tests\Domain\Livraison;

use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;

test('confirmerLivraison met à jour le statut et la date', function () {
    $livraison = new Livraison('l1', null, null, StatutLivraison::EN_ROUTE);
    $livraison->confirmerLivraison();
    expect($livraison->getStatut())->toBe(StatutLivraison::LIVREE);
    expect($livraison->getDateLivraisonEffective())->not->toBeNull();
});

test('assignerTransporteur met à jour le statut et le transporteur', function () {
    $livraison = new Livraison('l1', null, null, StatutLivraison::PROPOSEE);
    $transporteur = new Transporteur('t1', 'Dupont', 'dupont@mail.com', '123', 'Pick-up');
    $livraison->assignerTransporteur($transporteur);
    expect($livraison->getTransporteur())->toBe($transporteur);
    expect($livraison->getStatut())->toBe(StatutLivraison::ASSIGNEE);
});
