<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un consommateur de rechercher un produit spécifique par mot-clé.
 */
class RechercheProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Recherche des produits correspondants au mot-clé fourni.
     *
     * @param string $keyword Le terme recherché (ex: "Manioc", "Banane").
     * @return array Tableau des produits correspondants.
     * @throws \InvalidArgumentException Si le mot-clé est vide.
     */
    public function execute(string $keyword): array
    {
        $nettoye = trim($keyword);

        if (empty($nettoye)) {
            throw new \InvalidArgumentException('Le mot-clé de recherche ne peut pas être vide.');
        }

        return $this->produitRepository->searchByKeyword($nettoye);
    }
}
