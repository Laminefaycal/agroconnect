<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;

class MettreAJourStockUseCase
{
    private $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }
public function execute(string $produitId, array $data): void
    {
        $produit = $this->produitRepository->findById($produitId);

        if (!$produit) {
            throw new \Exception("Produit introuvable.");
        }


        $produit->update($data);

        $this->produitRepository->save($produit);
    }
}

