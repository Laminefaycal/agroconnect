<?php

namespace App\Application\Consommateur\DTO;

/**
 * Class PasserCommandeDto
 * * Transporte les données requises pour initier et valider le passage d'une commande.
 *
 * @package App\Application\Consommateur\DTO
 */
class PasserCommandeDto
{
    /**
     * L'identifiant unique du consommateur qui passe la commande.
     * @var string
     */
    private string $consommateurId;

    /**
     * La liste des lignes composant le panier de la commande.
     * @var LigneCommandeDto[]
     */
    private array $panier;

    /**
     * L'adresse complète de livraison pour la commande.
     * @var string
     */
    private string $adresseLivraison;

    /**
     * PasserCommandeDto constructor.
     *
     * @param string $consommateurId L'identifiant du consommateur.
     * @param LigneCommandeDto[] $panier Tableau d'objets LigneCommandeDto représentant le panier.
     * @param string $adresseLivraison L'adresse de livraison de la commande.
     */
    public function __construct(string $consommateurId, array $panier, string $adresseLivraison)
    {
        $this->consommateurId = $consommateurId;
        $this->panier = $panier;
        $this->adresseLivraison = $adresseLivraison;
    }

    /**
     * Récupère l'identifiant du consommateur.
     *
     * @return string
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
     *
     * @return string
     */
    public function getAdresseLivraison(): string
    {
        return $this->adresseLivraison;
    }
}