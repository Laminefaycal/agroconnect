<?php

namespace App\Application\Agriculteur\UseCase;

<<<<<<< HEAD
use App\Domain\Repository\ProduitRepositoryInterface;

/**
 * Cas d'utilisation pour ajuster la quantité disponible en stock d'un produit.
 */
class MettreAJourStockUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt pour la gestion des produits.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository
    ) {}

    /**
     * Modifie la quantité de stock disponible pour un produit donné.
     *
     * @param string $produitId L'identifiant du produit.
     * @param int $quantite La nouvelle quantité absolue ou le différentiel de stock.
     * @return void
     */
    public function execute(string $produitId, int $quantite): void
    {
        // Logique de mise à jour du stock...
=======
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
>>>>>>> feature/implementer-use-cases-agriculteur
    }
}
