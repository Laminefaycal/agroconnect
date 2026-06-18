<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\TransporteurRepositoryInterface;
use App\Domain\Interface\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Application\Agriculteur\Dto\ValiderCommandeDto;

class ValiderCommandeUseCase
{
    private $commandeRepository;
    private $transporteurRepository;
    private $livraisonRepository;
    private $serviceLivraison;

    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        TransporteurRepositoryInterface $transporteurRepository,
        LivraisonRepositoryInterface $livraisonRepository,
        ServiceLivraison $serviceLivraison
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->transporteurRepository = $transporteurRepository;
        $this->livraisonRepository = $livraisonRepository;
        $this->serviceLivraison = $serviceLivraison;
    }

    public function execute(ValiderCommandeDto $dto): void
    {
        // 1. Récupérer la commande
        $commande = $this->commandeRepository->findById($dto->getCommandeId());
        if (!$commande) {
            throw new \Exception("Commande introuvable.");
        }

        // 2. Valider le statut de la commande côté domaine
        $commande->valider();
        $this->commandeRepository->save($commande);

        // 3. Utiliser le service de domaine pour planifier ou gérer la livraison
        // Exemple avec le ServiceLivraison injecté
        $livraison = $this->serviceLivraison->planifier($commande, $dto->getTransporteurId());

        // 4. Sauvegarder la livraison générée
        $this->livraisonRepository->save($livraison);
    }
}
