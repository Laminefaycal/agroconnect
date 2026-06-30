<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\AccepterLivraisonDto;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Services\ServiceLivraison;
use App\Domain\Transporteur\TransporteurRepositoryInterface;
use RuntimeException;

/**
 * Class AccepterLivraisonUseCase
 * * Gère la prise en charge d'une livraison par un transporteur.
 */
class AccepterLivraisonUseCase
{
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository,
        private TransporteurRepositoryInterface $transporteurRepository,
        private ServiceLivraison $serviceLivraison
    ) {}

    /**
     * Exécute l'acceptation d'une livraison par un transporteur.
     *
     * @throws Exception
     */
    public function execute(AccepterLivraisonDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());
        if (! $livraison) {
            throw new RuntimeException("La livraison avec l'identifiant '{$dto->getLivraisonId()}' n'existe pas.");
        }

        $transporteur = $this->transporteurRepository->findById($dto->getTransporteurId());
        if (! $transporteur) {
            throw new RuntimeException("Le transporteur avec l'identifiant '{$dto->getTransporteurId()}' n'existe pas.");
        }

        if ($livraison->getStatut() !== StatutLivraison::PROPOSEE) {
            throw new RuntimeException(
                "La livraison n'est pas proposée aux transporteurs (statut actuel : {$livraison->getStatut()->value})."
            );
        }

        $this->serviceLivraison->affecterTransporteur($livraison, $transporteur);
    }
}
