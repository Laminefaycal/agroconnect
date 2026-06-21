<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Produit\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un consommateur de consulter le catalogue des produits.
 */
class ConsulterCatalogueUseCase
{
    /**
     * @var ProduitRepositoryInterface
     */
    private ProduitRepositoryInterface $produitRepository;

    /**
     * @param ProduitRepositoryInterface $produitRepository
     */
    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    /**
     * Exécute la consultation du catalogue.
     *
     * @return array Liste de tous les produits disponibles.
     */
    public function execute(): array
    {
        return $this->produitRepository->findAllAvailable();
    }
}
