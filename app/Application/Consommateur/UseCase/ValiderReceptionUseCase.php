<?php

namespace App\Application\Consommateur\UseCase;

use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use App\Application\Consommateur\Dto\ValiderReceptionDto;

/**
 * Cas d'utilisation permettant au consommateur de valider la bonne réception de sa commande.
 */
class ValiderReceptionUseCase
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
     * Valide la réception d'une livraison spécifique.
     *
     * @param ValiderReceptionDto $dto
     * @return void
     */
    public function execute(ValiderReceptionDto $dto): void
    {
        $commandeId = $dto->getCommandeId();

        $commande = $this->commandeRepository->findById($commandeId);

        if (!$commande) {
            throw new \Exception('Commande introuvable.');
        }

        $livraison = $this->livraisonRepository->findByCommandeId($commandeId);

        if (!$livraison) {
            throw new \Exception('Livraison introuvable.');
        }

        $livraison->confirmerReception();

        $this->livraisonRepository->save($livraison);
    }
}
