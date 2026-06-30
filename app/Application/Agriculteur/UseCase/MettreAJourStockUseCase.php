<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;

/**
 * Use Case : Mettre à jour le stock d’un produit existant.
 *
 * L’agriculteur peut fixer une nouvelle quantité en stock pour un produit.
 * La valeur doit être un entier (≥ 0 généralement).
 */
class MettreAJourStockUseCase
{
    public function __construct(
        private ProduitRepositoryInterface $produitRepository,
    ) {}

    /**
     * Exécute la mise à jour du stock.
     *
     * @param  string  $produitId  Identifiant du produit
     * @param  int  $quantite  Nouvelle quantité en stock (peut être 0)
     *
     * @throws \InvalidArgumentException Si le produit n’existe pas
     */
    public function execute(string $produitId, int $quantite): void
    {
        $produit = $this->produitRepository->findById($produitId);
        if (! $produit) {
            throw new \InvalidArgumentException("Produit '$produitId' introuvable.");
        }

        $produit->setStock($quantite);
        $this->produitRepository->save($produit);
    }
}
