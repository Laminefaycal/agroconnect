<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Repository\ProduitRepositoryInterface;
use App\Domain\Repository\AgriculteurRepositoryInterface;
use App\Application\Agriculteur\DTO\PublierProduitDto;

/**
 * Cas d'utilisation pour la création et la publication d'un nouveau produit par un agriculteur.
 */
class PublierProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt des produits.
     * @param AgriculteurRepositoryInterface $agriculteurRepository Le dépôt des agriculteurs.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository,
        private AgriculteurRepositoryInterface $agriculteurRepository
    ) {}

    /**
     * Crée un produit à partir du DTO et le publie sur la plateforme.
     *
     * @param PublierProduitDto $dto Le conteneur de données pour la publication.
     * @return mixed Le produit nouvellement créé et publié.
     */
    public function execute(PublierProduitDto $dto): mixed
    {
        // Logique de création et persistance...
        return null;
    }
}
