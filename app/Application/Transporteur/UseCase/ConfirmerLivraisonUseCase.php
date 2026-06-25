<?php

namespace App\Application\Transporteur\UseCase;

use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use Exception;

/**
 * Class ConfirmerLivraisonUseCase
 * * Permet de clôturer et confirmer qu'une livraison a bien été remise à destination.
 * * @package App\Application\Transporteur\UseCase
 */
class ConfirmerLivraisonUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la confirmation finale de la livraison.
     * * @param string $livraisonId
     * @return void
     * @throws Exception
     */
    public function execute(string $livraisonId): void
    {
        $livraison = $this->livraisonRepository->findById($livraisonId);

        if (!$livraison) {
            throw new Exception("Livraison introuvable.");
        }

        $livraison->changerStatut('livre');

        $this->livraisonRepository->save($livraison);
    }
}
