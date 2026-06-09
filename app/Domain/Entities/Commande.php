<?php

namespace App\Domain\Entities;

class Commande
{
    private ?int $idCommande; // Clé Primaire [PK]
    private string $dateDeCommande;
    private string $statutCommande;
    private float $montantTotal;

    public function __construct(
        ?int $idCommande,
        string $dateDeCommande,
        string $statutCommande,
        float $montantTotal
    ) {
        $this->idCommande = $idCommande;
        $this->dateDeCommande = $dateDeCommande;
        $this->statutCommande = $statutCommande;
        $this->montantTotal = $montantTotal;
    }

    // Getters
    public function getIdCommande(): ?int { return $this->idCommande; }
    public function getDateDeCommande(): string { return $this->dateDeCommande; }
    public function getStatutCommande(): string { return $this->statutCommande; }
    public function getMontantTotal(): float { return $this->montantTotal; }
}