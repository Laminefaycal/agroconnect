<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;

class SupprimerProduitUseCase
{
    private $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

   public function execute(string $produitId): void
{
    $produit = $this->produitRepository->findById($produitId);

    if (!$produit) {
        throw new \Exception('Produit introuvable.');
    }

    $this->produitRepository->delete($produitId);
}
}
