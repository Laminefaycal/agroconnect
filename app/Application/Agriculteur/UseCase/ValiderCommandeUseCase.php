<?php

namespace App\Application\Agriculteur\UseCase;

use App\Application\Agriculteur\DTO\ValiderCommandeDto;
use App\Domain\Commande\Commande;
use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Services\ServiceLivraison;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;

class ValiderCommandeUseCase
{
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private TransporteurRepositoryInterface $transporteurRepository,
        private LivraisonRepositoryInterface $livraisonRepository,
        private ServiceLivraison $serviceLivraison,
    ) {
    }

    public function execute(ValiderCommandeDto $dto): void
    {
        $commande = $this->commandeRepository->findById($dto->commandeId);
        if (!$commande) {
            throw new \InvalidArgumentException("Commande '{$dto->commandeId}' introuvable.");
        }

        if ($commande->getStatut() !== StatutCommande::EN_ATTENTE_VALIDATION) {
            throw new \InvalidArgumentException(
                "Seules les commandes en attente de validation peuvent être validées."
            );
        }

        if (!$dto->estDisponible) {
            throw new \InvalidArgumentException(
                "Seules les commandes disponibles peuvent être validées."
            );
        }

        $transporteur = null;
        if ($dto->modeLivraison === ModeLivraison::TRANSPORTEUR) {
            if (empty($dto->transporteurId)) {
                throw new \InvalidArgumentException(
                    "Le mode TRANSPORTEUR nécessite un identifiant de transporteur."
                );
            }
            $transporteur = $this->transporteurRepository->findById($dto->transporteurId);
            if (!$transporteur) {
                throw new \InvalidArgumentException(
                    "Transporteur '{$dto->transporteurId}' introuvable."
                );
            }
        }

        $commande->valider();
        $commande->choisirModeLivraison($dto->modeLivraison);

        $livraison = $this->creerLivraison($commande);

        if ($transporteur) {
            $commande->assignerTransporteur($transporteur);
            $this->serviceLivraison->affecterTransporteur($livraison, $transporteur);
        }

        $this->commandeRepository->save($commande);
        $this->livraisonRepository->save($livraison);
    }

    private function creerLivraison(Commande $commande): Livraison
    {
        $livraison = new Livraison(
            commandeId: $commande->getId(),
            datePriseEnCharge: null,
            dateLivraisonEffective: null,
            statut: StatutLivraison::ASSIGNEE,
            transporteur: null
        );
        return $livraison;
    }
}
