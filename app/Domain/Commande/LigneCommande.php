<?php

namespace App\Domain\Commande;

/**
 * Class LigneCommande
 *
 * Représente un article spécifique au sein d'une commande.
 * Cette classe gère la quantité commandée et le prix unitaire appliqué au moment de l'achat.
 *
 * @package App\Domain\Commande
 */
class LigneCommande
{
    /**
     * Constructeur de la ligne de commande avec promotion de propriétés.
     *
     * @param int $quantite La quantité de produits commandés.
     * @param float $prixUnitaire Le prix unitaire du produit (en FCFA).
     */
    public function __construct(
        private int $quantite,
        private float $prixUnitaire,
    ) {}

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
     *
     * @return int
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }

    /**
     * Récupère le prix unitaire de la ligne.
     *
     * @return float
     */
    public function getPrixUnitaire(): float
    {
        return $this->prixUnitaire;
    }
}