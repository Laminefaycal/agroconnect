<?php

namespace App\Application\Consommateur\DTO;

/**
 * Class LigneCommandeDto
 * * Représente un élément du panier contenant un produit spécifique et sa quantité associés.
 */
class LigneCommandeDto
{
    /**
     * L'identifiant unique du produit.
     */
    private string $produitId;

    /**
     * La quantité commandée pour ce produit.
     */
    private int $quantite;

    /**
     * LigneCommandeDto constructor.
     *
     * @param  string  $produitId  L'identifiant unique du produit.
     * @param  int  $quantite  La quantité demandée.
     */
    public function __construct(string $produitId, int $quantite)
    {
        $this->produitId = $produitId;
        $this->quantite = $quantite;
    }

    /**
     * Récupère l'identifiant du produit.
     */
    public function getProduitId(): string
    {
        return $this->produitId;
    }

    /**
     * Récupère la quantité du produit.
     */
    public function getQuantite(): int
    {
        return $this->quantite;
    }
}
