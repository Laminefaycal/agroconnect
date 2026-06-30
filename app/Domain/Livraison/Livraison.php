<?php

namespace App\Domain\Livraison;

use App\Domain\Commande\Commande;
use App\Domain\Transporteur\Transporteur;
use DateTime;

class Livraison
{
    private ?string $id;

    private string $commandeId;

    private ?DateTime $datePriseEnCharge;

    private ?DateTime $dateLivraisonEffective;

    private StatutLivraison $statut;

    private ?Transporteur $transporteur = null;

    public function __construct(
        string $commandeId,
        ?DateTime $datePriseEnCharge = null,
        ?DateTime $dateLivraisonEffective = null,
        StatutLivraison $statut = StatutLivraison::ASSIGNEE,
        ?Transporteur $transporteur = null,
        ?string $id = null,
    ) {
        $this->id = $id;
        $this->commandeId = $commandeId;
        $this->datePriseEnCharge = $datePriseEnCharge;
        $this->dateLivraisonEffective = $dateLivraisonEffective;
        $this->statut = $statut;
        $this->transporteur = $transporteur;
    }

    public function associerCommande(Commande $commande): void
    {
        $this->commandeId = $commande->getId();
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

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCommandeId(): string
    {
        return $this->commandeId;
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
