<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Interface\Repository\ProduitRepositoryInterface;

class ModifierProduitUseCase
{
    private $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    public function execute(string $produitId, array $data): void
    {
        // 1. Récupérer le produit via le repository
        $produit = $this->produitRepository->findById($produitId);

        if (!$produit) {
            throw new \Exception("Produit non trouvé.");
        }

        // 2. Modifier les propriétés (Logique métier ou appel d'une méthode de l'entité)
        // Exemple : $produit->modifier($data);

        // 3. Sauvegarder les modifications
        $this->produitRepository->save($produit);
    }
}
