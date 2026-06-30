<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Produit\ProduitRepositoryInterface;
use InvalidArgumentException;

class ModifierProduitUseCase
{
    private $produitRepository;

    public function __construct(ProduitRepositoryInterface $produitRepository)
    {
        $this->produitRepository = $produitRepository;
    }

    public function execute(string $produitId, array $data): void
    {
        $produit = $this->produitRepository->findById($produitId);

        if (! $produit) {
            throw new InvalidArgumentException('Produit non trouvé.');
        }

        if (isset($data['nom'])) {
            $produit->setNom($data['nom']);
        }
        if (isset($data['description'])) {
            $produit->setDescription($data['description']);
        }
        if (isset($data['prixUnitaire'])) {
            $produit->setPrixUnitaire($data['prixUnitaire']);
        }
        if (isset($data['stock'])) {
            $produit->setStock($data['stock']);
        }
        if (isset($data['unite'])) {
            $produit->setUnite($data['unite']);
        }

        $this->produitRepository->save($produit);
    }
}
