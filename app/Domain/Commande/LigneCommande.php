<?php

namespace App\Domain\Commande;

class LigneCommande
{
    public function __construct(
        private int $quantite,
        private float $prixUnitaire
    ) {}
}