<?php

namespace Tests\Domain\Commande;

use App\Domain\Commande\Commande;
use App\Domain\Commande\LigneCommande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use DateTime;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

describe('Commande', function () {

    it('peut être créée avec les bons attributs', function () {
        $date = new DateTime('2026-01-01');
        $commande = new Commande(
            dateCommande: $date,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: 'cmd-123'
        );

        expect($commande->getId())->toBe('cmd-123')
            ->and($commande->getDateCommande())->toEqual($date)
            ->and($commande->getStatut())->toBe(StatutCommande::EN_ATTENTE_VALIDATION)
            ->and($commande->getModeLivraison())->toBe(ModeLivraison::TRANSPORTEUR)
            ->and($commande->getLignes())->toBeEmpty()
            ->and($commande->getLivraison())->toBeNull();
    });

    it('valide une commande en attente', function () {
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        $commande->valider();

        expect($commande->getStatut())->toBe(StatutCommande::VALIDEE);
    });

    it('lève une exception si on valide une commande qui n\'est pas en attente', function () {
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::VALIDEE,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        expect(fn () => $commande->valider())->toThrow(InvalidArgumentException::class, 'Seule une commande en attente peut être validée.');
    });

    it('change le mode de livraison', function () {
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        $commande->choisirModeLivraison(ModeLivraison::AGRICULTEUR);

        expect($commande->getModeLivraison())->toBe(ModeLivraison::AGRICULTEUR);
    });

    it('assigne un transporteur et passe en livraison si le mode est TRANSPORTEUR', function () {
        $transporteur = Mockery::mock(Transporteur::class);

        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::VALIDEE,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        $commande->assignerTransporteur($transporteur);

        expect($commande->getStatut())->toBe(StatutCommande::EN_LIVRAISON)
            ->and($commande->getLivraison())->not->toBeNull()
            ->and($commande->getLivraison()->getStatut())->toBe(StatutLivraison::ASSIGNEE);
    });

    it('lève une exception si on tente d\'assigner un transporteur en mode AGRICULTEUR', function () {
        $transporteur = Mockery::mock(Transporteur::class);

        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::VALIDEE,
            modeLivraison: ModeLivraison::AGRICULTEUR,
            id: null
        );

        expect(fn () => $commande->assignerTransporteur($transporteur))
            ->toThrow(InvalidArgumentException::class, 'Impossible d’assigner un transporteur en mode livraison par agriculteur.');
    });

    it('peut ajouter des lignes de commande', function () {
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        $ligne1 = Mockery::mock(LigneCommande::class);
        $ligne2 = Mockery::mock(LigneCommande::class);

        $commande->ajouterLigne($ligne1);
        $commande->ajouterLigne($ligne2);

        expect($commande->getLignes())->toHaveCount(2)
            ->and($commande->getLignes()[0])->toBe($ligne1)
            ->and($commande->getLignes()[1])->toBe($ligne2);
    });

    it('permet de définir une livraison existante', function () {
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR,
            id: null
        );

        $livraison = Mockery::mock(Livraison::class);
        $commande->setLivraison($livraison);

        expect($commande->getLivraison())->toBe($livraison);
    });
});
