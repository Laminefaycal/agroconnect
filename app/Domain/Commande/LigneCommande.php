<?php

namespace App\Domain\Commande;

use App\Domain\Produit\Produit;

/**
 * Class LigneCommande
 *
 * Représente un article spécifique au sein d'une commande.
 * Cette classe gère la quantité commandée et le prix unitaire appliqué au moment de l'achat.
 */
class LigneCommande
{
    private Produit $produit;

    private int $quantite;

    private float $prixUnitaire;

    public function __construct(Produit $produit, int $quantite, float $prixUnitaire)
    {
        $this->produit = $produit;
        $this->quantite = $quantite;
        $this->prixUnitaire = $prixUnitaire;
    }

    /**
     * Calcule le montant total pour cette ligne de commande.
     *
     * @return float Le sous-total (Quantité * Prix Unitaire).
     */
    public function calculerSousTotal(): float
    {
        return $this->quantite * $this->prixUnitaire;
    }

    /**
     * Récupère la quantité commandée.
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    /**
     * Récupère le prix unitaire de la ligne.
     */
    public function getPrixUnitaire(): float
    {
        return $this->prixUnitaire;
    }

    public function getProduit(): Produit
    {
        return $this->produit;
    }
}
