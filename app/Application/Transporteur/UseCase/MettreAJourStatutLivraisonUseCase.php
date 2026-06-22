<?php

namespace App\Application\Transporteur\UseCase;

use App\Application\Transporteur\DTO\MiseAJourStatutDto;
use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use Exception;

/**
 * Class MettreAJourStatutLivraisonUseCase
 * * Permet de faire progresser l'état d'une livraison.
 * * @package App\Application\Transporteur\UseCase
 */
class MettreAJourStatutLivraisonUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la mise à jour du statut.
     * * @param MiseAJourStatutDto $dto
     * @return void
     * @throws Exception
     */
    public function execute(MiseAJourStatutDto $dto): void
    {
        $livraison = $this->livraisonRepository->findById($dto->getLivraisonId());

        if (!$livraison) {
            throw new Exception("Livraison introuvable.");
        }

        $livraison->changerStatut($dto->getStatut());

        $this->livraisonRepository->save($livraison);
    }
}
