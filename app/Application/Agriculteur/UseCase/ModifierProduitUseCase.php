<?php

namespace App\Application\Agriculteur\UseCase;

<<<<<<< HEAD
use App\Domain\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un agriculteur de modifier les informations d'un produit.
 */
class ModifierProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt pour la gestion des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Exécute la modification du produit.
     *
     * @param string $produitId L'identifiant unique du produit à modifier.
     * @param array $data Les nouvelles données à appliquer au produit.
     * @return void
     * @throws \Exception Si le produit n'est pas trouvé.
     */
    public function execute(string $produitId, array $data): void
    {
        // Logic de modification...
=======
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
>>>>>>> feature/implementer-use-cases-agriculteur
    }
}
