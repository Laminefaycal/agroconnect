<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\Commande\Commande;
use App\Domain\Commande\StatutCommande;
use App\Domain\Commande\ModelLivraison;
use DateTime;

/**
 * Class CommandeTest
 *
 * Test unitaire pour l'entité Commande.
 * Vérifie que la logique métier de validation modifie correctement l'état de l'objet.
 */
class CommandeTest extends TestCase
{
    /**
     * Vérifie qu'une commande change correctement de statut lorsqu'elle est validée.
     *
     * @return void
     */
    public function test_une_commande_peut_etre_validee(): void
    {
        // 1. ARRANGE (Préparation d'une commande en attente)
        $commande = new Commande(
            'cmd-456',
            new DateTime(),
            StatutCommande::EN_ATTENTE_VALIDATION,
            ModelLivraison::TRANSPORTEUR
        );

        // 2. ACT (Exécution de la méthode de validation)
        $commande->valider();

        // 3. ASSERT (Vérification que le statut a bien basculé)
        $this->assertEquals(StatutCommande::VALIDEE, $commande->getStatut());
    }
}