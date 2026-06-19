<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un agriculteur de modifier les informations d'un produit.
 */
class ModifierProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt pour la gestion des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Exécute la modification du produit.
     *
     * @param string $produitId L'identifiant unique du produit à modifier.
     * @param array $data Les nouvelles données à appliquer au produit.
     * @return void
     * @throws \Exception Si le produit n'est pas trouvé.
     */
    public function execute(string $produitId, array $data): void
    {
        // Logic de modification...
    }
}
