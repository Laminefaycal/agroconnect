<?php

namespace Tests\Domain\Commande;

use App\Domain\Commande\LigneCommande;
use App\Domain\Produit\Produit;
use PHPUnit\Framework\TestCase;

class LigneCommandeTest extends TestCase
{
    public function test_le_calcul_du_sous_total_est_correct(): void
    {
        $quantite = 3;
        $prixUnitaire = 1500.0;
        $totalAttendu = 4500.0;

        // Create a mock Produit (we don't need any behavior for this test)
        $produit = $this->createMock(Produit::class);

        $ligneCommande = new LigneCommande($produit, $quantite, $prixUnitaire);

        $this->assertEquals($totalAttendu, $ligneCommande->calculerSousTotal());
    }
}
