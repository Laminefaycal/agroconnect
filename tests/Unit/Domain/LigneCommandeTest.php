<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\Commande\LigneCommande;

/**
 * Class LigneCommandeTest
 *
 * Test unitaire pour l'entité LigneCommande.
 * Vérifie que le calcul mathématique du sous-total s'exécute sans erreur.
 */
class LigneCommandeTest extends TestCase
{
    /**
     * Vérifie que le sous-total d'une ligne de commande est correctement calculé.
     *
     * @return void
     */
    public function test_le_calcul_du_sous_total_est_correct(): void
    {
        // 1. ARRANGE (Une ligne avec 3 produits à 1500 FCFA l'unité)
        $quantite = 3;
        $prixUnitaire = 1500.0;
        $totalAttendu = 4500.0; // 3 * 1500

        $ligneCommande = new LigneCommande($quantite, $prixUnitaire);

        // 2. ACT (Exécution du calcul)
        $montantCalcule = $ligneCommande->calculerSousTotal();

        // 3. ASSERT (Vérification du résultat)
        $this->assertEquals($totalAttendu, $montantCalcule);
    }
}