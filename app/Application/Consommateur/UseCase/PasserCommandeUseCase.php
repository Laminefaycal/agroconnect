<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\ConsommateurRepositoryInterface;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Service\ServiceDisponibilite;
use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Commande;

/**
 * Cas d'utilisation gérant la création et le passage d'une commande par un consommateur.
 */
class PasserCommandeUseCase
{
    /**
     * @param CommandeRepositoryInterface $commandeRepository
     * @param ConsommateurRepositoryInterface $consommateurRepository
     * @param ProduitRepositoryInterface $produitRepository
     * @param ServiceDisponibilite $serviceDisponibilite
     */
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private ConsommateurRepositoryInterface $consommateurRepository,
        private ProduitRepositoryInterface $produitRepository,
        private ServiceDisponibilite $serviceDisponibilite
    ) {}

    /**
     * Orchestre les vérifications métier et enregistre la nouvelle commande.
     *
     * @param PasserCommandeDto $dto Les données de la commande.
     * @return Commande L'entité de la commande créée.
     * @throws \Exception Si le consommateur ou le produit n'existe pas, ou si le stock est insuffisant.
     */
    public function execute(PasserCommandeDto $dto): Commande
    {
        // 1. Validation de l'existence du consommateur
        $consommateur = $this->consommateurRepository->findById($dto->getConsommateurId());
        if (!$consommateur) {
            throw new \Exception('Consommateur introuvable.');
        }

        // 2. Validation du produit et de sa disponibilité logistique
        $produit = $this->produitRepository->findById($dto->getProduitId());
        if (!$produit) {
            throw new \Exception('Produit introuvable.');
        }

        if (!$this->serviceDisponibilite->estDisponiblePourZone($produit, $dto->getAdresseLivraison())) {
            throw new \DomainException('Ce produit ne peut pas être livré dans votre zone.');
        }

        // 3. Règle métier : Vérification et déduction des stocks du producteur
        if ($produit->getQuantite() < $dto->getQuantite()) {
            throw new \DomainException('Stock insuffisant pour ce produit.');
        }

        // Mettre à jour le stock du produit au sein du domaine
        $produit->retirerDuStock($dto->getQuantite());
        $this->produitRepository->save($produit);

        // 4. Instanciation et sauvegarde de la commande
        $commande = new Commande(
            id: uniqid('cmd_'),
            consommateurId: $dto->getConsommateurId(),
            produitId: $dto->getProduitId(),
            quantite: $dto->getQuantite(),
            adresseLivraison: $dto->getAdresseLivraison()
        );

        return $this->commandeRepository->save($commande);
    }
}
