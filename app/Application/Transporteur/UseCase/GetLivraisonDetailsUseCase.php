<?php

namespace App\Application\Transporteur\UseCase;

use App\Domain\Transporteur\Repository\LivraisonRepositoryInterface;
use App\Domain\Transporteur\Entity\Livraison;
use Exception;

/**
 * Class GetLivraisonDetailsUseCase
 * * Permet de récupérer les détails complets d'une livraison spécifique.
 * * @package App\Application\Transporteur\UseCase
 */
class GetLivraisonDetailsUseCase
{
    /**
     * @param LivraisonRepositoryInterface $livraisonRepository
     */
    public function __construct(
        private LivraisonRepositoryInterface $livraisonRepository
    ) {}

    /**
     * Exécute la récupération des détails d'une livraison.
     * * @param string $livraisonId
     * @return Livraison
     * @throws Exception
     */
    public function execute(string $livraisonId): Livraison
    {
        $livraison = $this->livraisonRepository->findById($livraisonId);

        if (!$livraison) {
            throw new Exception("Livraison non trouvée.");
        }

        return $livraison;
    }
}
