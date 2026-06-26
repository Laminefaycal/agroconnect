<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Repository\ProduitRepositoryInterface;
use App\Domain\Repository\AgriculteurRepositoryInterface;
use App\Application\Agriculteur\DTO\PublierProduitDto;
use App\Domain\Produit\Produit;
use App\Application\Agriculteur\UseCase\Exception\AgriculteurInexistantException;
use App\Application\Agriculteur\UseCase\Exception\ProduitNonSauvegardeException;

/**
 * Cas d'utilisation pour la création et la publication d'un nouveau produit par un agriculteur.
 */
class PublierProduitUseCase
{
    /**
     * @param ProduitRepositoryInterface $produitRepository Le dépôt des produits.
     * @param AgriculteurRepositoryInterface $agriculteurRepository Le dépôt des agriculteurs.
     */
    public function __construct(
        private ProduitRepositoryInterface $produitRepository,
        private AgriculteurRepositoryInterface $agriculteurRepository
    ) {}

    /**
     * Crée un produit à partir du DTO et le publie sur la plateforme.
     *
     * @param PublierProduitDto $dto Le conteneur de données pour la publication.
     * @return Produit Le produit nouvellement créé et publié.
     */
    public function execute(PublierProduitDto $dto): Produit
    {
        $agriculteur = $this->agriculteurRepository->findById($dto->agriculteurId);
        if (!$agriculteur) {
             throw new AgriculteurInexistantException(sprintf("L'agriculteur avec l'identifiant '%s' n'existe pas.", $dto->agriculteurId));
        }
        $produit = new Produit($dto->nom, $dto->description, $dto->prix, $dto->stock, $dto->unite);
        $produit->setAgriculteur($agriculteur);
        $produitSauvegarde = $this->produitRepository->save($produit);
        if (!$produitSauvegarde) {
            throw new ProduitNonSauvegardeException('Impossible de sauvegarder le produit.');
        }
        return $produitSauvegarde;
    }
}
