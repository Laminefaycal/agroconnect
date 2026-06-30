<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use InvalidArgumentException;

/**
 * Cas d'utilisation permettant au consommateur de suivre l'état d'avancement de sa livraison.
 */
class SuivreLivraisonUseCase
{
    private CommandeRepositoryInterface $commandeRepository;

    private LivraisonRepositoryInterface $livraisonRepository;

    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        LivraisonRepositoryInterface $livraisonRepository
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->livraisonRepository = $livraisonRepository;
    }

    /**
     * Récupère les détails de suivi d'une commande/livraison.
     *
     * @param  string  $commandeId  L'identifiant de la commande concernée.
     * @return Livraison L'objet livraison associé.
     *
     * @throws InvalidArgumentException si la commande ou la livraison n'existe pas.
     */
    public function execute(string $commandeId): Livraison
    {
        $commande = $this->commandeRepository->findById($commandeId);
        if ($commande === null) {
            throw new InvalidArgumentException("Commande introuvable avec l'ID : ".$commandeId);
        }

        $livraison = $commande->getLivraison();
        if ($livraison === null) {
            throw new InvalidArgumentException('Aucune livraison associée à cette commande.');
        }

        return $livraison;
    }
}
