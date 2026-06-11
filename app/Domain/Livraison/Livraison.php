<?php

namespace App\Domain\Livraison;

use DateTime;

class Livraison
{
    public function __construct(
        private string $id,
        private ?DateTime $datePriseEnCharge,
        private ?DateTime $dateLivraisonEffective,
        private StatutLivraison $statutLivraison
    ) {}

    public function mettreAJourStatut(StatutLivraison $statut): void
    {
        $this->statutLivraison = $statut;
    }

    public function confirmerLivraison(): void
    {
        $this->statutLivraison = StatutLivraison::LIVREE;
        $this->dateLivraisonEffective = new DateTime();
    }
}