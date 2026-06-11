<?php

namespace App\Domain\Commande;

use App\Domain\Transporteur\Transporteur;
use DateTime;

/**
 * Class Commande
 *
 * Représente une commande passée sur la plateforme AgroConnect.
 * Cette entité gère le cycle de vie d'une commande, son statut, son mode de livraison
 * ainsi que l'assignation du transporteur logistique.
 *
 * @package App\Domain\Commande
 */
class Commande
{
    /**
     * Constructeur de l'entité Commande avec promotion de propriétés.
     *
     * @param string $id L'identifiant unique de la commande.
     * @param DateTime $dateCommande La date et l'heure de création de la commande.
     * @param StatutCommande $statut Le statut actuel de la commande (En attente, Validée, etc.).
     * @param ModelLivraison $modeLivraison Le mode de livraison sélectionné par le client.
     */
    public function __construct(
        private string $id,
        private DateTime $dateCommande,
        private StatutCommande $statut,
        private ModelLivraison $modeLivraison,
    ) {}

    /**
     * Valide la commande en faisant passer son statut à 'VALIDEE'.
     *
     * @return void
     */
    public function valider(): void
    {
        $this->statut = StatutCommande::VALIDEE;
    }

    /**
     * Définit ou modifie le mode de livraison de la commande.
     *
     * @param ModelLivraison $mode Le nouveau mode de livraison à appliquer.
     * @return void
     */
    public function choisirModelLivraison(ModelLivraison $mode): void
    {
        $this->modeLivraison = $mode;
    }

    /**
     * Assigne un prestataire logistique (Transporteur) pour l'acheminement de la commande.
     *
     * @param Transporteur $transporteur Le transporteur sélectionné.
     * @return void
     */
    public function assignerTransporteur(Transporteur $transporteur): void
    {
        // Logique d'assignation
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDateCommande(): DateTime
    {
        return $this->dateCommande;
    }

    /**
     * @return StatutCommande
     */
    public function getStatut(): StatutCommande
    {
        return $this->statut;
    }

    /**
     * @return ModelLivraison
     */
    public function getModeLivraison(): ModelLivraison
    {
        return $this->modeLivraison;
    }
}