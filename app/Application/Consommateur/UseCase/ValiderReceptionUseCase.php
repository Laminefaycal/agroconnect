<?php

namespace App\Application\Consommateur\UseCase;

use App\Application\Consommateur\Dto\ValiderReceptionDto;
use App\Domain\Commande\Repository\CommandeRepositoryInterface;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\Repository\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use InvalidArgumentException;

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
     * @throws InvalidArgumentException si la commande ou la livraison est introuvable, ou si le statut ne permet pas la validation.
     */
    public function execute(ValiderReceptionDto $dto): void
    {
        $commande = $this->commandeRepository->findById($dto->getCommandeId());
        if ($commande === null) {
            throw new InvalidArgumentException("Commande introuvable avec l'ID : ".$dto->getCommandeId());
        }
        $livraison = $commande->getLivraison();
        if ($livraison === null) {
            throw new InvalidArgumentException('Aucune livraison associée à cette commande.');
        }
        $statutActuel = $livraison->getStatut();
        // Statuts acceptés : avant la livraison effective
        $statutsAcceptes = [
            StatutLivraison::ASSIGNEE,
            StatutLivraison::PRISE_EN_CHARGE,
            StatutLivraison::EN_ROUTE,
        ];
        if (! in_array($statutActuel, $statutsAcceptes, true)) {
            throw new InvalidArgumentException(
                "La livraison est déjà dans un état final (statut actuel : {$statutActuel->value})."
            );
        }
        if (! $dto->isEstLivree()) {
            throw new InvalidArgumentException("La réception n'a pas été confirmée par le consommateur.");
        }
        $livraison->mettreAJourStatut(StatutLivraison::LIVREE);
        $commande->setStatut(StatutCommande::LIVREE);
        $this->livraisonRepository->save($livraison);
        $this->commandeRepository->save($commande);
    }
}
