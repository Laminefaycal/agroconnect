<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Produit;

interface ProduitRepositoryInterface
{
    public function trouverParId(int $idProduit): ?Produit;
    public function sauvegarder(Produit $produit): Produit;
    public function recupererTousLeCatalogue(): array;
    public function mettreAJourLeStock(int $idProduit, int $nouvelleQuantite): bool;
}