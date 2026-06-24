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
        throw new \Exception('Produit introuvable.');
    }

    if ($quantite < 0) {
        throw new \InvalidArgumentException(
            'Le stock ne peut pas être négatif.'
        );
    }

    $produit->setQuantite($quantite);

    $this->produitRepository->save($produit);
}
}
