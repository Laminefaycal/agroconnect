<?php

namespace Test\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\PasserCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\LigneCommande;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\ConsommateurRepositoryInterface;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Service\ServiceDisponibilite;
use DateTime;

/**
 * Cas d'utilisation gérant la création et le passage d'une commande par un consommateur.
 */
class PasserCommandeUseCase
{
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private ConsommateurRepositoryInterface $consommateurRepository,
        private ProduitRepositoryInterface $produitRepository,
        private ServiceDisponibilite $serviceDisponibilite
    ) {}

    /**
     * Orchestre les vérifications métier et enregistre la nouvelle commande.
     *
     * @param  PasserCommandeDto  $dto  Les données de la commande.
     * @return Commande L'entité de la commande créée.
     *
     * @throws \Exception Si le consommateur ou le produit n'existe pas, ou si le stock est insuffisant.
     */
    public function execute(PasserCommandeDto $dto): Commande
    {
        // 1. Validation de l'existence du consommateur
        $consommateur = $this->consommateurRepository->findById($dto->getConsommateurId());
        if (! $consommateur) {
            throw new \Exception('Consommateur introuvable.');
        }

        // 2. Validation du produit et de sa disponibilité logistique
        $produit = $this->produitRepository->findById($dto->getProduitId());
        if (! $produit) {
            throw new \Exception('Produit introuvable.');
        }

        if (! $this->serviceDisponibilite->estDisponiblePourZone($produit, $dto->getAdresseLivraison())) {
            throw new \DomainException('Ce produit ne peut pas être livré dans votre zone.');
        }

        // 3. Règle métier : Vérification et déduction des stocks du producteur
        if ($produit->getQuantite() < $dto->getQuantite()) {
            throw new \DomainException('Stock insuffisant pour ce produit.');
        }

        // Mettre à jour le stock du produit au sein du domaine
        $produit->retirerDuStock($dto->getQuantite());
        $this->produitRepository->save($produit);

        $commande = new Commande(
            id: uniqid('cmd_'),
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: ModeLivraison::TRANSPORTEUR
        );

        $ligneCommande = new LigneCommande(
            id: uniqid('ligne_'),
            produitId: $dto->getProduitId(),
            quantite: $dto->getQuantite()
        );

        $commande->ajouterLigne($ligneCommande);

        // Optionnel : si ton entité stocke l'adresse de livraison directement
        if (method_exists($commande, 'setAdresseLivraison')) {
            $commande->setAdresseLivraison($dto->getAdresseLivraison());
        }

        return $this->commandeRepository->save($commande);
    }
}
