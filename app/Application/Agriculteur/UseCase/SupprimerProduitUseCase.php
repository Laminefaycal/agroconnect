<?php

namespace App\Application\Agriculteur\UseCase;

<<<<<<< HEAD
use App\Domain\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation permettant à un agriculteur de supprimer un produit de son catalogue.
 */
class SupprimerProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt pour la gestion des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Exécute la suppression du produit.
     *
     * @param string $produitId L'identifiant unique du produit à supprimer.
     * @return void
     * @throws \Exception Si le produit n'existe pas ou ne peut pas être supprimé.
     */
    public function execute(string $produitId): void
    {
        // Logique de suppression...
=======
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
            throw new \Exception("Produit introuvable.");
        }

        $this->produitRepository->delete($produitId);
>>>>>>> feature/implementer-use-cases-agriculteur
    }
}
