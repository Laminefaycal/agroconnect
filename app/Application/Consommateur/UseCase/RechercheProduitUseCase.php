<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Produit\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant de rechercher des produits par mot-clé.
 */
class RechercheProduitUseCase
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
     * Exécute la recherche de produits.
     *
     * @param string $keyword Le mot-clé de recherche.
     * @return array Liste des produits correspondants.
     */
    public function execute(string $keyword): array
    {
        return $this->produitRepository->searchByKeyword($keyword);
    }
}
