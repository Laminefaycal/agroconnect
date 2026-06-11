<?php

namespace App\Domain\Services;

use App\Domain\Produit\Produit;

class ServiceDisponibilite
{
    public function verifierStock(Produit $produit, int $quantite): bool
    {
        return $produit->estDisponible($quantite);
    }
}