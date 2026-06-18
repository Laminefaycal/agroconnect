<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Interface\Repository\ProduitRepositoryInterface;

class MettreAJourStockUseCase
{
    private $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    public function execute(string $produitId, int $quantite): void
    {
        $produit = $this->produitRepository->findById($produitId);

        if (!$produit) {
            throw new \Exception("Produit introuvable pour la mise à jour du stock.");
        }

        // Met à jour la quantité sur l'entité
        $produit->setQuantite($quantite);

        $this->produitRepository->save($produit);
    }
}
