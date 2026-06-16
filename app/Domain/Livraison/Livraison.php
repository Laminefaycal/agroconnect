<?php

namespace App\Domain\Livraison;

use DateTime;

/**
 * Class Livraison
 *
 * Gère le suivi logistique de l'acheminement des produits sur AgroConnect.
 * Permet de suivre la prise en charge, de mettre à jour les statuts de transit
 * et d'enregistrer la date de livraison effective.
 */
class Livraison
{
    /**
     * Constructeur de l'entité Livraison avec promotion de propriétés.
     *
     * @param  string  $id  L'identifiant unique de la livraison.
     * @param  DateTime|null  $datePriseEnCharge  La date à laquelle le transporteur récupère les produits.
     * @param  DateTime|null  $dateLivraisonEffective  La date réelle de remise des produits au client.
     * @param  StatutLivraison  $statutLivraison  Le statut actuel (En préparation, En transit, Livrée, etc.).
     */
    public function __construct(
        private string $id,
        private ?DateTime $datePriseEnCharge,
        private ?DateTime $dateLivraisonEffective,
        private StatutLivraison $statutLivraison,
    ) {}

    /**
     * Met à jour manuellement le statut de la livraison.
     *
     * @param  StatutLivraison  $statut  Le nouveau statut à appliquer.
     */
    public function mettreAJourStatut(StatutLivraison $statut): void
    {
        $this->statutLivraison = $statut;
    }

    /**
     * Confirme la livraison finale en enregistrant le statut comme 'LIVREE'
     * et en figeant la date et l'heure effectives du jour.
     */
    public function confirmerLivraison(): void
    {
        $this->statutLivraison = StatutLivraison::LIVREE;
        $this->dateLivraisonEffective = new DateTime;
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

    public function getStatutLivraison(): StatutLivraison
    {
        return $this->statutLivraison;
    }
}
