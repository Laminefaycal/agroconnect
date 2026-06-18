<?php

namespace Test\Application\Agriculteur\UseCase;

use App\Domain\Entity\Produit;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Interface\Repository\AgriculteurRepositoryInterface;
use App\Application\Agriculteur\Dto\PublierProduitDto;

class PublierProduitUseCase
{
    private $produitRepository;
    private $agriculteurRepository;

    public function __construct(
        ProduitRepositoryInterface $produitRepository,
        AgriculteurRepositoryInterface $agriculteurRepository
    ) {
        $this->produitRepository = $produitRepository;
        $this->agriculteurRepository = $agriculteurRepository;
    }

    public function execute(PublierProduitDto $dto): Produit
    {
        // Vérifier si l'agriculteur existe
        $agriculteur = $this->agriculteurRepository->findById($dto->getAgriculteurId());
        if (!$agriculteur) {
            throw new \Exception("Agriculteur introuvable.");
        }

        // Instancier la nouvelle entité Produit à partir du DTO
        $produit = new Produit(
            // Remplir avec les getters de votre DTO
            $dto->getNom(),
            $dto->getPrix(),
            $dto->getQuantite(),
            $dto->getAgriculteurId()
        );

        // Enregistrer le produit
        return $this->produitRepository->save($produit);
    }
}
