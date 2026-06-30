<?php

namespace App\Application\Consommateur\UseCase;

use App\Application\Consommateur\DTO\PasserCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\LigneCommande;
use App\Domain\Commande\StatutCommande;
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\ConsommateurRepositoryInterface;
use App\Domain\Interface\Repository\ProduitRepositoryInterface;
use App\Domain\Service\ServiceDisponibilite;
use DateTime;
use Exception;

class PasserCommandeUseCase
{
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private ConsommateurRepositoryInterface $consommateurRepository,
        private ProduitRepositoryInterface $produitRepository,
        private ServiceDisponibilite $serviceDisponibilite
    ) {}

    /**
     * @throws Exception
     */
    public function execute(PasserCommandeDto $dto): Commande
    {
        $consommateur = $this->consommateurRepository->findById($dto->getConsommateurId());
        if (! $consommateur) {
            throw new Exception('Consommateur introuvable.');
        }
        $commande = new Commande(
            dateCommande: new DateTime,
            statut: StatutCommande::EN_ATTENTE_VALIDATION,
            modeLivraison: $dto->getModeLivraison(),
            id: null
        );
        foreach ($dto->getPanier() as $ligneDto) {
            $produit = $this->produitRepository->findById($ligneDto->getProduitId());
            if (! $produit) {
                throw new Exception('Produit introuvable : '.$ligneDto->getProduitId());
            }
            if (! $this->serviceDisponibilite->verifierStock($produit, $ligneDto->getQuantite())) {
                throw new Exception('Stock insuffisant pour le produit : '.$produit->getNom());
            }
            $ligneCommande = new LigneCommande(
                $produit,
                $ligneDto->getQuantite(),
                $produit->getPrixUnitaire()
            );
            $commande->ajouterLigne($ligneCommande);
            $produit->decrementerStock($ligneDto->getQuantite());
            $this->produitRepository->save($produit);
        }
        $commandeSauveger = $this->commandeRepository->save($commande);

        return $commandeSauveger;
    }
}
