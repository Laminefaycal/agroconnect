<?php

namespace App\Domain\Entities;

class LigneCommande
{
    private int $idCommande; // Clé Étrangère et Primaire [PK, FK]
    private int $idProduit;  // Clé Étrangère et Primaire [PK, FK]
    private int $quantiteCommandee;

    public function __construct(int $idCommande, int $idProduit, int $quantiteCommandee)
    {
        $this->idCommande = $idCommande;
        $this->idProduit = $idProduit;
        $this->quantiteCommandee = $quantiteCommandee;
    }

    // Getters
    public function getIdCommande(): int { return $this->idCommande; }
    public function getIdProduit(): int { return $this->idProduit; }
    public function getQuantiteCommandee(): int { return $this->quantiteCommandee; }
}