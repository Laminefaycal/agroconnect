<?php

namespace App\Application\Consommateur\DTO;

use App\Domain\Commande\ModeLivraison;

class PasserCommandeDto
{
    private string $consommateurId;

    private array $panier; // LigneCommandeDto[]

    private string $adresseLivraison;

    private ModeLivraison $modeLivraison;

    public function __construct(
        string $consommateurId,
        array $panier,
        string $adresseLivraison,
        ?ModeLivraison $modeLivraison = null
    ) {
        $this->consommateurId = $consommateurId;
        $this->panier = $panier;
        $this->adresseLivraison = $adresseLivraison;
        $this->modeLivraison = $modeLivraison ?? ModeLivraison::TRANSPORTEUR;
    }

    public function getConsommateurId(): string
    {
        return $this->consommateurId;
    }

    /** @return LigneCommandeDto[] */
    public function getPanier(): array
    {
        return $this->panier;
    }

    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }

    public function getModeLivraison(): ModeLivraison
    {
        return $this->modeLivraison;
    }
}
