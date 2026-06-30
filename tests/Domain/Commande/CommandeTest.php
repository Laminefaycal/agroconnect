<?php

namespace Tests\Domain\Commande;

use App\Domain\Commande\Commande;
use App\Domain\Commande\LigneCommande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Livraison;
use App\Domain\Transporteur\Transporteur;
use DateTime;
use InvalidArgumentException;
use Mockery;

it('peut être instanciée correctement avec ses valeurs initiales', function () {
    $date = new DateTime;
    $commande = new Commande('CMD-123', $date, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);

    expect($commande->getId())->toBe('CMD-123')
        ->and($commande->getDateCommande())->toBe($date)
        ->and($commande->getStatut())->toBe(StatutCommande::EN_ATTENTE_VALIDATION)
        ->and($commande->getModeLivraison())->toBe(ModeLivraison::TRANSPORTEUR)
        ->and($commande->getLignes())->toBeEmpty()
        ->and($commande->getLivraison())->toBeNull();
});

it('peut être validée avec succès si elle est en attente de validation', function () {
    $commande = new Commande('CMD-123', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);

    $commande->valider();

    expect($commande->getStatut())->toBe(StatutCommande::VALIDEE);
});

it('lève une exception si on valide une commande qui n\'est pas en attente de validation', function () {
    $commande = new Commande('CMD-123', new DateTime, StatutCommande::VALIDEE, ModeLivraison::TRANSPORTEUR);

    expect(fn () => $commande->valider())
        ->toThrow(InvalidArgumentException::class, 'Seule une commande en attente peut être validée.');
});

it('peut changer son mode de livraison', function () {
    $commande = new Commande('CMD-123', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);

    $commande->choisirModeLivraison(ModeLivraison::AGRICULTEUR);

    expect($commande->getModeLivraison())->toBe(ModeLivraison::AGRICULTEUR);
});

it('peut ajouter des lignes de commande', function () {
    $commande = new Commande('CMD-123', new DateTime, StatutCommande::EN_ATTENTE_VALIDATION, ModeLivraison::TRANSPORTEUR);
    $ligneMock = mock(LigneCommande::class);

    $commande->ajouterLigne($ligneMock);

    expect($commande->getLignes())->toHaveCount(1)
        ->and($commande->getLignes()[0])->toBe($ligneMock);

});
it('utilise la livraison existante pour y assigner le transporteur', function () {
    // 1. Arrange
    $commande = Mockery::mock(Commande::class)->makePartial();
    $commande->shouldReceive('getModeLivraison')->andReturn(ModeLivraison::TRANSPORTEUR);

    // 💡 LA CORRECTION : On redonne la vraie classe, Mockery va générer le bon type
    $livraisonMock = Mockery::mock(Livraison::class);
    $transporteurMock = Mockery::mock(Transporteur::class);

    // Configuration des comportements
    $commande->shouldReceive('setLivraison')->with($livraisonMock)->andReturnSelf();
    $commande->shouldReceive('getLivraison')->andReturn($livraisonMock);
    $commande->shouldReceive('getStatut')->andReturn(StatutCommande::EN_LIVRAISON);
    $commande->shouldReceive('assignerTransporteur')->with($transporteurMock)->once();

    // 2. Act
    // On appelle la méthode via le mock partiel
    $commande->setLivraison($livraisonMock);
    $commande->assignerTransporteur($transporteurMock);

    // 3. Assert
    expect($commande->getLivraison())->toBe($livraisonMock)
        ->and($commande->getStatut())->toBe(StatutCommande::EN_LIVRAISON);
});
it('lève une exception si on assigne un transporteur alors que le mode est AGRICULTEUR', function () {
    $commande = new Commande('CMD-123', new DateTime, StatutCommande::VALIDEE, ModeLivraison::AGRICULTEUR);
    $transporteurMock = mock(Transporteur::class);

    expect(fn () => $commande->assignerTransporteur($transporteurMock))
        ->toThrow(InvalidArgumentException::class, 'Impossible d’assigner un transporteur en mode livraison par agriculteur.');
});
