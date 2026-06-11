<?php

namespace App\Domain\Produit;

/**
 * Interface ProduitRepositoryInterface
 *
 * Spécifie le contrat de persistance pour le catalogue de produits agricoles.
 * Assure le découplage entre la logique d'inventaire du Domaine et les requêtes en base de données.
 *
 * @package App\Domain\Produit
 */
interface ProduitRepositoryInterface
{
    /**
     * Recherche un produit spécifique par son identifiant unique.
     *
     * @param string $id L'identifiant du produit.
     * @return Produit|null L'entité Produit correspondante, ou null si elle n'existe pas.
     */
    public function findById(string $id): ?Produit;

    /**
     * Récupère l'intégralité des produits disponibles dans le catalogue AgroConnect.
     *
     * @return array Liste de toutes les entités Produit.
     */
    public function findAll(): array;

    /**
     * Filtre et recherche les produits par mots-clés (ex: nom, catégorie ou description).
     *
     * @param string $keyword Le mot-clé saisi par l'utilisateur.
     * @return array La liste des entités Produit correspondantes.
     */
    public function search(string $keyword): array;

    /**
     * Sauvegarde un nouveau produit ou met à jour les informations d'un produit existant.
     *
     * @param Produit $produit L'entité Produit à persister.
     * @return void
     */
    public function save(Produit $produit): void;

    /**
     * Supprime définitivement un produit du catalogue à partir de son identifiant.
     *
     * @param string $id L'identifiant du produit à retirer.
     * @return void
     */
    public function delete(string $id): void;
}