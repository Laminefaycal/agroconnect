<?php

namespace App\Domain\Livraison;

/**
 * Interface LivraisonRepositoryInterface
 *
 * Définit le contrat de persistance pour la gestion logistique des livraisons.
 * Permet de découpler la gestion des flux de transport de l'infrastructure technique.
 */
interface LivraisonRepositoryInterface
{
    /**
     * Recherche un enregistrement de livraison par son identifiant unique.
     *
     * @param  string  $id  L'identifiant de la livraison.
     * @return Livraison|null L'entité Livraison correspondante, ou null si elle n'existe pas.
     */
    public function findById(string $id): ?Livraison;

    /**
     * Récupère l'ensemble des livraisons en attente ou prêtes à être prises en charge.
     * utile pour afficher les missions disponibles pour les transporteurs.
     *
     * @return array Liste des entités Livraison disponibles.
     */
    public function findDisponibles(): array;

    /**
     * Sauvegarde ou met à jour les informations d'une livraison.
     *
     * @param  Livraison  $livraison  L'entité Livraison à persister.
     */
    public function save(Livraison $livraison): void;
}
