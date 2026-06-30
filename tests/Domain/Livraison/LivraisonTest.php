<?php

namespace Tests\Domain\Livraison;

use App\Domain\Commande\Commande;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use DateTime;

describe('Livraison', function () {
    it('peut être instanciée avec les paramètres minimaux', function () {
        $commandeId = 'cmd-123';
        $livraison = new Livraison($commandeId);

        expect($livraison->getId())->toBeNull();
        expect($livraison->getCommandeId())->toBe($commandeId);
        expect($livraison->getDatePriseEnCharge())->toBeNull();
        expect($livraison->getDateLivraisonEffective())->toBeNull();
        expect($livraison->getStatut())->toBe(StatutLivraison::ASSIGNEE);
        expect($livraison->getTransporteur())->toBeNull();
    });

    it('peut être instanciée avec tous les paramètres', function () {
        $commandeId = 'cmd-123';
        $datePriseEnCharge = new DateTime('2026-06-26 10:00:00');
        $dateLivraisonEffective = new DateTime('2026-06-27 14:30:00');
        $statut = StatutLivraison::EN_ROUTE;
        $transporteur = new Transporteur('tr-456', 'John Doe', 'john@example.com', '0612345678', 'Camion');
        $id = 'liv-789';

        $livraison = new Livraison(
            commandeId: $commandeId,
            datePriseEnCharge: $datePriseEnCharge,
            dateLivraisonEffective: $dateLivraisonEffective,
            statut: $statut,
            transporteur: $transporteur,
            id: $id
        );

        expect($livraison->getId())->toBe($id);
        expect($livraison->getCommandeId())->toBe($commandeId);
        expect($livraison->getDatePriseEnCharge())->toBe($datePriseEnCharge);
        expect($livraison->getDateLivraisonEffective())->toBe($dateLivraisonEffective);
        expect($livraison->getStatut())->toBe($statut);
        expect($livraison->getTransporteur())->toBe($transporteur);
    });

    it('permet de modifier l\'ID via setId', function () {
        $livraison = new Livraison('cmd-123');
        $nouvelId = 'liv-456';
        $livraison->setId($nouvelId);

        expect($livraison->getId())->toBe($nouvelId);
    });

    it('associe une commande via associerCommande', function () {
        $commande = mock(Commande::class);
        $commande->shouldReceive('getId')->andReturn('cmd-999');

        $livraison = new Livraison('cmd-123');
        $livraison->associerCommande($commande);

        expect($livraison->getCommandeId())->toBe('cmd-999');
    });

    it('met à jour le statut via mettreAJourStatut', function () {
        $livraison = new Livraison('cmd-123');
        $livraison->mettreAJourStatut(StatutLivraison::PRISE_EN_CHARGE);

        expect($livraison->getStatut())->toBe(StatutLivraison::PRISE_EN_CHARGE);
    });

    it('confirme la livraison et met à jour le statut et la date', function () {
        $livraison = new Livraison('cmd-123');
        $livraison->confirmerLivraison();

        expect($livraison->getStatut())->toBe(StatutLivraison::LIVREE);
        expect($livraison->getDateLivraisonEffective())->toBeInstanceOf(DateTime::class);
    });

    it('assigne un transporteur et passe le statut à ASSIGNEE', function () {
        $transporteur = new Transporteur('tr-456', 'John Doe', 'john@example.com', '0612345678', 'Camion');
        $livraison = new Livraison('cmd-123', statut: StatutLivraison::PROPOSEE);

        $livraison->assignerTransporteur($transporteur);

        expect($livraison->getTransporteur())->toBe($transporteur);
        expect($livraison->getStatut())->toBe(StatutLivraison::ASSIGNEE);
    });

    it('retourne null pour les getters si les valeurs sont absentes', function () {
        $livraison = new Livraison('cmd-123');
        expect($livraison->getDatePriseEnCharge())->toBeNull();
        expect($livraison->getDateLivraisonEffective())->toBeNull();
        expect($livraison->getTransporteur())->toBeNull();
    });
});
