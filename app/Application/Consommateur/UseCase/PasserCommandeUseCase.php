<?php

namespace App\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\LigneCommande;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Consommateur\Repository\ConsommateurRepositoryInterface;
use App\Domain\Produit\Repository\ProduitRepositoryInterface;
use App\Domain\Services\ServiceDisponibilite;
use DateTime;

/**
 * Cas d'utilisation gérant l'action de passer une commande par le consommateur.
 */
class PasserCommandeUseCase
{
    /** @var CommandeRepositoryInterface */
    private CommandeRepositoryInterface $commandeRepository;

    /** @var ConsommateurRepositoryInterface */
    private ConsommateurRepositoryInterface $consommateurRepository;

    /** @var ProduitRepositoryInterface */
    private ProduitRepositoryInterface $produitRepository;

    /** @var ServiceDisponibilite */
    private ServiceDisponibilite $serviceDisponibilite;

    /**
     * @param CommandeRepositoryInterface $commandeRepository
     * @param ConsommateurRepositoryInterface $consommateurRepository
     * @param ProduitRepositoryInterface $produitRepository
     * @param ServiceDisponibilite $serviceDisponibilite
     */
    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        ConsommateurRepositoryInterface $consommateurRepository,
        ProduitRepositoryInterface $produitRepository,
        ServiceDisponibilite $serviceDisponibilite
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->consommateurRepository = $consommateurRepository;
        $this->produitRepository = $produitRepository;
        $this->serviceDisponibilite = $serviceDisponibilite;
    }

    /**
     * Exécute le processus de création et d'enregistrement d'une commande.
     *
     * @param PasserCommandeDto $dto
     * @return Commande La commande générée.
     * @throws \InvalidArgumentException Si un produit n'est pas disponible ou introuvable.
     */
    public function execute(PasserCommandeDto $dto): Commande
    {
        // Le Service de Domaine vérifie si les lignes du DTO sont disponibles en stock
        if (!$this->serviceDisponibilite->verifierLignes($dto->lignes)) {
            throw new \InvalidArgumentException("Certains produits demandés ne sont plus disponibles en quantité suffisante.");
        }

        $commande = new Commande(
            id: uniqid('cmd-'),
            dateCommande: new DateTime(),
            statut: \App\Domain\Commande\StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: $dto->modeLivraison
        );

        // Transformation de chaque tableau array en entité LigneCommande
        foreach ($dto->lignes as $ligneData) {
            // 💡 Récupération de l'objet Produit requis par LigneCommande via son Repository
            $produit = $this->produitRepository->findById($ligneData['produitId']);

            if (!$produit) {
                throw new \InvalidArgumentException("Le produit avec l'ID {$ligneData['produitId']} n'existe pas.");
            }

            // Instanciation conforme à la signature : Produit, int, float
            $ligneCommande = new LigneCommande(
                $produit,
                $ligneData['quantite'],
                $produit->getPrix() // Récupère le prix actuel du produit pour fixer le prix unitaire
            );

            $commande->ajouterLigne($ligneCommande);
        }

        $this->commandeRepository->save($commande);

        return $commande;
    }
}
