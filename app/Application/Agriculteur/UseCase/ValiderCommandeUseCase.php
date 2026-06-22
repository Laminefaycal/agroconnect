<?php

namespace App\Application\Agriculteur\UseCase;

<<<<<<< HEAD
use App\Domain\Repository\CommandeRepositoryInterface;
use App\Domain\Repository\TransporteurRepositoryInterface;
use App\Domain\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Application\Agriculteur\DTO\ValiderCommandeDto;

/**
 * Cas d'utilisation gérant la validation d'une commande par l'agriculteur
 * et déclenchant la préparation de la livraison avec un transporteur.
 */
class ValiderCommandeUseCase
{
    /**
     * @param CommandeRepositoryInterface $commandeRepository Le dépôt des commandes.
     * @param TransporteurRepositoryInterface $transporteurRepository Le dépôt des transporteurs.
     * @param LivraisonRepositoryInterface $livraisonRepository Le dépôt des livraisons.
     * @param ServiceLivraison $serviceLivraison Le service de domaine pour orchestrer la livraison.
     */
    public function __construct(
        private CommandeRepositoryInterface $commandeRepository,
        private TransporteurRepositoryInterface $transporteurRepository,
        private LivraisonRepositoryInterface $livraisonRepository,
        private ServiceLivraison $serviceLivraison
    ) {}

    /**
     * Valide la commande et initialise le processus logistique de livraison.
     *
     * @param ValiderCommandeDto $dto Le conteneur de données contenant l'ID de la commande et du transporteur sélectionné.
     * @return void
     * @throws \Exception Si la commande ou le transporteur n'est pas valide.
     */
    public function execute(ValiderCommandeDto $dto): void
    {
        // Logique métier complexe (Validation + Lien Transporteur)...
=======
use App\Domain\Interface\Repository\CommandeRepositoryInterface;
use App\Domain\Interface\Repository\TransporteurRepositoryInterface;
use App\Domain\Interface\Repository\LivraisonRepositoryInterface;
use App\Domain\Service\ServiceLivraison;
use App\Application\Agriculteur\Dto\ValiderCommandeDto;

class ValiderCommandeUseCase
{
    private $commandeRepository;
    private $transporteurRepository;
    private $livraisonRepository;
    private $serviceLivraison;

    public function __construct(
        CommandeRepositoryInterface $commandeRepository,
        TransporteurRepositoryInterface $transporteurRepository,
        LivraisonRepositoryInterface $livraisonRepository,
        ServiceLivraison $serviceLivraison
    ) {
        $this->commandeRepository = $commandeRepository;
        $this->transporteurRepository = $transporteurRepository;
        $this->livraisonRepository = $livraisonRepository;
        $this->serviceLivraison = $serviceLivraison;
    }

    public function execute(ValiderCommandeDto $dto): void
    {
        // 1. Récupérer la commande
        $commande = $this->commandeRepository->findById($dto->getCommandeId());
        if (!$commande) {
            throw new \Exception("Commande introuvable.");
        }

        // 2. Valider le statut de la commande côté domaine
        $commande->valider();
        $this->commandeRepository->save($commande);

        // 3. Utiliser le service de domaine pour planifier ou gérer la livraison
        // Exemple avec le ServiceLivraison injecté
        $livraison = $this->serviceLivraison->planifier($commande, $dto->getTransporteurId());

        // 4. Sauvegarder la livraison générée
        $this->livraisonRepository->save($livraison);
>>>>>>> feature/implementer-use-cases-agriculteur
    }
}
