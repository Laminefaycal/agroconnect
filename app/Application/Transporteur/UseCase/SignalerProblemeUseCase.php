<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\SignalerProblemeDto;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use RuntimeException;

/**
 * Class SignalerProblemeUseCase
 *
 * Permet à un transporteur de notifier un problème ou un incident survenu lors d'une livraison.
 */
class SignalerProblemeUseCase
{
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute le signalement d'un incident sur une livraison.
     *
     * @throws RuntimeException Si la livraison n'existe pas ou si elle est déjà livrée.
     */
    public function execute(SignalerProblemeDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());
        if (! $livraison) {
            throw new RuntimeException(
                "La livraison avec l'identifiant '{$dto->getLivraisonId()}' n'existe pas."
            );
        }
        if ($livraison->getStatut() === StatutLivraison::LIVREE) {
            throw new RuntimeException(
                'Impossible de signaler un problème : la livraison est déjà marquée comme livrée.'
            );
        }
        $livraison->mettreAJourStatut(StatutLivraison::PROBLEME);
        $this->livraisonRepository->save($livraison);
    }
}
