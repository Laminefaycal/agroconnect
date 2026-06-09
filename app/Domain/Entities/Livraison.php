<?php

namespace App\Domain\Entities;

class Livraison
{
    private ?int $idLivraison; // Clé Primaire [PK]
    private string $destination;
    private float $coutLivraison;
    private string $statutLivraison;
    private int $idCommande;    // Clé Étrangère [FK]
    private int $idTransporteur; // Clé Étrangère [FK]

    public function __construct(
        ?int $idLivraison,
        string $destination,
        float $coutLivraison,
        string $statutLivraison,
        int $idCommande,
        int $idTransporteur
    ) {
        $this->idLivraison = $idLivraison;
        $this->destination = $destination;
        $this->coutLivraison = $coutLivraison;
        $this->statutLivraison = $statutLivraison;
        $this->idCommande = $idCommande;
        $this->idTransporteur = $idTransporteur;
    }

    // Getters
    public function getIdLivraison(): ?int { return $this->idLivraison; }
    public function getDestination(): string { return $this->destination; }
    public function getCoutLivraison(): float { return $this->coutLivraison; }
    public function getStatutLivraison(): string { return $this->statutLivraison; }
    public function getIdCommande(): int { return $this->idCommande; }
    public function getIdTransporteur(): int { return $this->idTransporteur; }
}