<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\ConfirmerLivraisonDto;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use RuntimeException;

/**
 * Class ConfirmerLivraisonUseCase
 *
 * Permet de clôturer et confirmer qu'une livraison a bien été remise à destination.
 */
class ConfirmerLivraisonUseCase
{
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la confirmation de livraison.
     *
     * @throws RuntimeException Si la livraison n'existe pas.
     */
    public function execute(ConfirmerLivraisonDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());
        if (! $livraison) {
            throw new RuntimeException(
                "La livraison avec l'identifiant '{$dto->getLivraisonId()}' n'existe pas."
            );
        }
        $livraison->confirmerLivraison();
        $this->livraisonRepository->save($livraison);
    }
}
