<?php

namespace App\Domain\Livraison;

use App\Domain\Transporteur\Transporteur;
use DateTime;

class Livraison
{
    private string $id;

    private ?DateTime $datePriseEnCharge;

    private ?DateTime $dateLivraisonEffective;

    private StatutLivraison $statut;

    private ?Transporteur $transporteur = null;

    public function __construct(
        string $id,
        ?DateTime $datePriseEnCharge,
        ?DateTime $dateLivraisonEffective,
        StatutLivraison $statut
    ) {
        $this->id = $id;
        $this->datePriseEnCharge = $datePriseEnCharge;
        $this->dateLivraisonEffective = $dateLivraisonEffective;
        $this->statut = $statut;
    }

    public function mettreAJourStatut(StatutLivraison $statut): void
    {
        $this->statut = $statut;
    }

    public function confirmerLivraison(): void
    {
        $this->statut = StatutLivraison::LIVREE;
        $this->dateLivraisonEffective = new DateTime;
    }

    public function assignerTransporteur(Transporteur $transporteur): void
    {
        $this->transporteur = $transporteur;
        $this->statut = StatutLivraison::ASSIGNEE;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDatePriseEnCharge(): ?DateTime
    {
        return $this->datePriseEnCharge;
    }

    public function getDateLivraisonEffective(): ?DateTime
    {
        return $this->dateLivraisonEffective;
    }

    public function getStatut(): StatutLivraison
    {
        return $this->statut;
    }

    public function getTransporteur(): ?Transporteur
    {
        return $this->transporteur;
    }
}
