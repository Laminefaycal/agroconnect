<?php

namespace App\Domain\Agriculteur;

/**
 * Interface AgriculteurRepositoryInterface
 *
 * Définit le contrat de persistance pour la gestion des entités Agriculteur.
 * Cette interface permet à la couche Domaine d'interagir avec les données sans dépendre
 * d'une infrastructure spécifique (base de données, ORM Eloquent, etc.).
 *
 * @package App\Domain\Agriculteur
 */
interface AgriculteurRepositoryInterface
{
    /**
     * Recherche un agriculteur par son identifiant unique.
     *
     * @param string $id L'identifiant de l'agriculteur à rechercher.
     * @return Agriculteur|null L'entité Agriculteur correspondante, ou null si elle n'existe pas.
     */
    public function findById(string $id): ?Agriculteur;

    /**
     * Sauvegarde ou met à jour une entité Agriculteur dans le système.
     *
     * @param Agriculteur $agriculteur L'entité à persister.
     * @return void
     */
    public function save(Agriculteur $agriculteur): void;

    /**
     * Récupère la liste de tous les produits associés à un agriculteur spécifique.
     *
     * @param string $id L'identifiant unique de l'agriculteur.
     * @return array Liste des produits appartenant à cet agriculteur.
     */
    public function findProduitsByAgriculteur(string $id): array;
}