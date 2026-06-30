<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\MiseAJourStatutDto;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use Exception;

/**
 * Class MettreAJourStatutLivraisonUseCase
 * * Permet de faire progresser l'état d'une livraison.
 */
class MettreAJourStatutLivraisonUseCase
{
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la mise à jour du statut.
     *
     * @throws Exception
     */
    public function execute(MiseAJourStatutDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());
        if (! $livraison) {
            throw new Exception('Livraison introuvable.');
        }
        $statut = $dto->getStatutEnum();
        $livraison->mettreAJourStatut($statut);

        $this->livraisonRepository->save($livraison);
    }
}
