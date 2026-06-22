<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\AccepterLivraisonDto;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Repository\TransporteurRepositoryInterface;
use App\Domain\Transporteur\Service\ServiceLivraison; // À adapter selon l'emplacement de votre service
use Exception;

/**
 * Class AccepterLivraisonUseCase
 * * Gère la prise en charge d'une livraison par un transporteur.
 * * @package App\Application\Transporteur\UseCase
 */
class AccepterLivraisonUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     * @param TransporteurRepositoryInterface $transporteurRepository
     * @param ServiceLivraison $serviceLivraison
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository,
        private TransporteurRepositoryInterface $transporteurRepository,
        private ServiceLivraison $serviceLivraison
    ) {}

    /**
     * Exécute l'acceptation d'une livraison par un transporteur.
     * * @param AccepterLivraisonDto $dto
     * @return void
     * @throws Exception
     */
    public function execute(AccepterLivraisonDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());
        if (!$livraison) {
            throw new Exception("Livraison introuvable.");
        }

        $transporteur = $this->transporteurRepository->findById($dto->getTransporteurId());
        if (!$transporteur) {
            throw new Exception("Transporteur introuvable.");
        }

        // Utilisation du service de livraison si nécessaire, ou logique métier directe
        $livraison->assignerTransporteur($transporteur->getId());
        $livraison->changerStatut('accepte');

        $this->livraisonRepository->save($livraison);
    }
}
