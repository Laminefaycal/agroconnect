<?php

namespace App\Domain\Entities;

class Produit
{
    private ?int $idProduit; // Clé Primaire [PK]
    private string $nom;
    private float $prix;
    private string $dateDeValidite;
    private int $quantiteStock;
    private string $provenance;

    public function __construct(
        ?int $idProduit,
        string $nom,
        float $prix,
        string $dateDeValidite,
        int $quantiteStock,
        string $provenance
    ) {
        $this->idProduit = $idProduit;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->dateDeValidite = $dateDeValidite;
        $this->quantiteStock = $quantiteStock;
        $this->provenance = $provenance;
    }

    // Getters
    public function getIdProduit(): ?int { return $this->idProduit; }
    public function getNom(): string { return $this->nom; }
    public function getPrix(): float { return $this->prix; }
    public function getDateDeValidite(): string { return $this->dateDeValidite; }
    public function getQuantiteStock(): int { return $this->quantiteStock; }
    public function getProvenance(): string { return $this->provenance; }
}