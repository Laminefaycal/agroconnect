<?php

namespace Tests\Domain;

use App\Domain\Commande\Commande;
use App\Domain\Commande\ModelLivraison;
use App\Domain\Commande\StatutCommande;
use DateTime;
use PHPUnit\Framework\TestCase;

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
     */
    public function test_une_commande_peut_etre_validee(): void
    {
        // 1. ARRANGE (Préparation d'une commande en attente)
        $commande = new Commande(
            'cmd-456',
            new DateTime,
            StatutCommande::EN_ATTENTE_VALIDATION,
            ModelLivraison::TRANSPORTEUR
        );

        // 2. ACT (Exécution de la méthode de validation)
        $commande->valider();

        // 3. ASSERT (Vérification que le statut a bien basculé)
        $this->assertEquals(StatutCommande::VALIDEE, $commande->getStatut());
    }
}
