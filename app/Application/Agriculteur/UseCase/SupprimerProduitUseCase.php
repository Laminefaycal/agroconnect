<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Interface\Repository\ProduitRepositoryInterface;

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

    if ($produit->aDesCommandesEnCours()) {
        throw new \DomainException(
            'Impossible de supprimer ce produit.'
        );
    }

    $this->produitRepository->delete($produitId);
}
}
