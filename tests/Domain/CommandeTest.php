<?php

namespace Tests\Domain;

use App\Domain\Commande\Commande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use DateTime;
use InvalidArgumentException;

use function expect;
use function test;

test('commande peut être validée si en attente', function () {
    $commande = new Commande('1', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);
    $commande->valider();
    expect($commande->getStatut())->toBe(StatutCommande::VALIDEE);
});

test('commande ne peut pas être validée si déjà validée', function () {
    $commande = new Commande('1', new DateTime, StatutCommande::VALIDEE, ModeLivraison::TRANSPORTEUR);
    expect(fn () => $commande->valider())->toThrow(InvalidArgumentException::class);
});

test('assigner transporteur en mode AGRICULTEUR lève une exception', function () {
    $commande = new Commande('1', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::AGRICULTEUR);
    $transporteur = new Transporteur('t1', 'John', 'john@mail.com', '123', 'Moto');
    expect(fn () => $commande->assignerTransporteur($transporteur))
        ->toThrow(InvalidArgumentException::class, 'Impossible d’assigner un transporteur en mode livraison par agriculteur.');
});

test('assigner transporteur crée une livraison si non existante', function () {
    $commande = new Commande('1', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);
    $transporteur = new Transporteur('t1', 'John', 'john@mail.com', '123', 'Moto');
    $commande->assignerTransporteur($transporteur);
    expect($commande->getLivraison())->not->toBeNull();
    expect($commande->getLivraison()->getStatut())->toBe(StatutLivraison::ASSIGNEE);
    expect($commande->getStatut())->toBe(StatutCommande::EN_LIVRAISON);
});
