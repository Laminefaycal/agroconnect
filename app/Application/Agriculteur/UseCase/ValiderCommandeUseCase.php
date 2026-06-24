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
    $commande = $this->commandeRepository
        ->findById($dto->commandeId);

    if (!$commande) {
        throw new \Exception(
            'Commande introuvable.'
        );
    }

    if (!$commande->estEnAttente()) {
        throw new \DomainException(
            'Commande déjà traitée.'
        );
    }

    $transporteur =
        $this->transporteurRepository
            ->trouverDisponible();

    if (!$transporteur) {
        throw new \DomainException(
            'Aucun transporteur disponible.'
        );
    }

    $commande->valider();

    $livraison =
        $this->serviceLivraison
            ->creerLivraison(
                $commande,
                $transporteur
            );

    $this->livraisonRepository
        ->save($livraison);

    $this->commandeRepository
        ->save($commande);
}
}
