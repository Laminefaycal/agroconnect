<?php

namespace App\Domain\Commande;

/**
 * Interface CommandeRepositoryInterface
 *
 * Contrat définissant les opérations de persistance et de recherche pour les entités Commande.
 * Permet de découpler la logique métier des commandes de la gestion technique de la base de données.
 */
interface CommandeRepositoryInterface
{
    /**
     * Recherche une commande spécifique par son identifiant unique.
     *
     * @param  string  $id  L'identifiant de la commande.
     * @return Commande|null L'entité Commande correspondante, ou null si introuvable.
     */
    public function findById(string $id): ?Commande;

    /**
     * Récupère l'historique de toutes les commandes passées par un consommateur donné.
     *
     * @param  string  $consommateurId  L'identifiant du consommateur (client).
     * @return array Liste des commandes associées à ce consommateur.
     */
    public function findByConsommateur(string $consommateurId): array;

    /**
     * Récupère la liste de toutes les commandes reçues par un agriculteur donné.
     *
     * @param  string  $agriculteurId  L'identifiant de l'agriculteur (producteur).
     * @return array Liste des commandes associées à cet agriculteur.
     */
    public function findByAgriculteur(string $agriculteurId): array;

    /**
     * Enregistre une nouvelle commande ou met à jour une commande existante.
     *
     * @param  Commande  $commande  L'entité Commande à persister.
     */
    public function save(Commande $commande): ?Commande;
}
