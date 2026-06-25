<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un consommateur de consulter le catalogue des produits disponibles.
 */
class ConsulterCatalogueUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Extrait la liste de tous les produits actifs du catalogue.
     *
     * @return array Tableau contenant les entités Produits disponibles.
     */
    public function execute(): array
    {
        // Logique métier : On ne récupère que les produits disponibles/en stock
        return $this->produitRepository->findByDisponibilite(true);
    }
}
