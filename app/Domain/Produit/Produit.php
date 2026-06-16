<?php

namespace App\Domain\Produit;

/**
 * Class Produit
 *
 * Représente un produit agricole proposé sur la plateforme AgroConnect.
 * Gère les informations de tarification, le conditionnement (unité) ainsi que
 * la logique métier liée aux mouvements de stock (vérification et décrémentation).
 */
class Produit
{
    /**
     * Constructeur de l'entité Produit avec promotion de propriétés.
     *
     * @param  string  $id  L'identifiant unique du produit.
     * @param  string  $nom  Le nom du produit (ex: Banane plantain, Manioc, etc.).
     * @param  string  $description  La description détaillée du produit.
     * @param  float  $prixUnitaire  Le prix d'une unité de produit (en FCFA).
     * @param  int  $stock  La quantité actuellement disponible en stock.
     * @param  string  $unite  L'unité de mesure du produit (ex: kg, régime, sac).
     */
    public function __construct(
        private string $id,
        private string $nom,
        private string $description,
        private float $prixUnitaire,
        private int $stock,
        private string $unite,
    ) {}

    /**
     * Vérifie si le stock actuel est suffisant pour couvrir la quantité demandée.
     *
     * @param  int  $quantite  La quantité requise pour une commande.
     * @return bool Vrai si le stock est supérieur ou égal, faux sinon.
     */
    public function estDisponible(int $quantite): bool
    {
        return $this->stock >= $quantite;
    }

    /**
     * Diminue la quantité en stock si la marchandise demandée est disponible.
     *
     * @param  int  $quantite  La quantité à soustraire du stock.
     */
    public function decrementerStock(int $quantite): void
    {
        if ($this->estDisponible($quantite)) {
            $this->stock -= $quantite;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrixUnitaire(): float
    {
        return $this->prixUnitaire;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getUnite(): string
    {
        return $this->unite;
    }
}
