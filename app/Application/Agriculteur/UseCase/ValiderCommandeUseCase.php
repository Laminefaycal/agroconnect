<?php

namespace App\Application\Agriculteur\UseCase;

use App\Domain\Repository\CommandeRepositoryInterface;
use App\Domain\Repository\TransporteurRepositoryInterface;
use App\Domain\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Application\Agriculteur\DTO\ValiderCommandeDto;

/**
 * Cas d'utilisation gérant la validation d'une commande par l'agriculteur
 * et déclenchant la préparation de la livraison avec un transporteur.
 */
class ValiderCommandeUseCase
{
    /**
     * @param CommandeRepositoryInterface $commandeRepository Le dépôt des commandes.
     * @param TransporteurRepositoryInterface $transporteurRepository Le dépôt des transporteurs.
     * @param LivraisonRepositoryInterface $livraisonRepository Le dépôt des livraisons.
     * @param ServiceLivraison $serviceLivraison Le service de domaine pour orchestrer la livraison.
     */
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private TransporteurRepositoryInterface $transporteurRepository,
        private LivraisonRepositoryInterface $livraisonRepository,
        private ServiceLivraison $serviceLivraison
    ) {}

    /**
     * Valide la commande et initialise le processus logistique de livraison.
     *
     * @param ValiderCommandeDto $dto Le conteneur de données contenant l'ID de la commande et du transporteur sélectionné.
     * @return void
     * @throws \Exception Si la commande ou le transporteur n'est pas valide.
     */
    public function execute(ValiderCommandeDto $dto): void
    {
        // Logique métier complexe (Validation + Lien Transporteur)...
    }
}
