<?php

namespace App\Application\Consommateur\DTO;

/**
 * Class PasserCommandeDto
 * * Transporte les données requises pour initier et valider le passage d'une commande.
 */
class PasserCommandeDto
{
    public array $lignes = [];
    public $modeLivraison;
    /**
     * L'identifiant unique du consommateur qui passe la commande.
     */
    private string $consommateurId;

    /**
     * La liste des lignes composant le panier de la commande.
     *
     * @var LigneCommandeDto[]
     */
    private array $panier;

    /**
     * L'adresse complète de livraison pour la commande.
     */
    private string $adresseLivraison;

    /**
     * PasserCommandeDto constructor.
     *
     * @param  string  $consommateurId  L'identifiant du consommateur.
     * @param  LigneCommandeDto[]  $panier  Tableau d'objets LigneCommandeDto représentant le panier.
     * @param  string  $adresseLivraison  L'adresse de livraison de la commande.
     */
    public function __construct(string $consommateurId, array $panier, string $adresseLivraison)
    {
        $this->consommateurId = $consommateurId;
        $this->panier = $panier;
        $this->adresseLivraison = $adresseLivraison;
    }

    /**
     * Récupère l'identifiant du consommateur.
     */
    public function getConsommateurId(): string
    {
        return $this->consommateurId;
    }

    /**
     * Récupère l'ensemble des lignes du panier de la commande.
     *
     * @return LigneCommandeDto[]
     */
    public function getPanier(): array
    {
        return $this->panier;
    }

    /**
     * Récupère l'adresse de livraison spécifiée.
     */
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }
}
