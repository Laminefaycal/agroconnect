<?php

namespace App\Domain\Services;

use App\Domain\Commande\CommandeRepositoryInterface;
use App\Domain\Commande\ModeLivraison;
use App\Domain\Livraison\Livraison;
use App\Domain\Livraison\LivraisonRepositoryInterface;
use App\Domain\Livraison\StatutLivraison;
use App\Domain\Transporteur\Transporteur;
use App\Domain\Transporteur\TransporteurRepositoryInterface;

/**
 * Class ServiceLivraison
 *
 * Service du Domaine (Domain Service) gérant les interactions complexes et les flux
 * de mise en relation entre les livraisons de marchandises et les transporteurs partenaires.
 */
class ServiceLivraison
{
    public function __construct(
        private TransporteurRepositoryInterface $transporteurRepository,
        private LivraisonRepositoryInterface $livraisonRepository,
        private CommandeRepositoryInterface $commandeRepository,
        private TransporteurNotificationInterface $notificationService
    ) {}

    /**
     * Propose la livraison aux transporteurs disponibles, sauf si le mode est AGRICULTEUR.
     */
    public function proposerAuxTransporteurs(Livraison $livraison): void
    {

        $commande = $this->commandeRepository->findByLivraisonId($livraison->getId());
        if (! $commande) {
            throw new \RuntimeException('Aucune commande associée à cette livraison.');
        }

        if ($commande->getModeLivraison() === ModeLivraison::AGRICULTEUR) {
            return;
        }

        $transporteurs = $this->transporteurRepository->findAllDisponibles();

        $livraison->mettreAJourStatut(StatutLivraison::PROPOSEE);
        $this->livraisonRepository->save($livraison);
    }

    /**
     * Gère l'affectation finale d'une livraison à un transporteur spécifique.
     *
     * @param  Livraison  $livraison  L'entité Livraison concernée.
     * @param  Transporteur  $transporteur  L'entité Transporteur qui prend en charge la course.
     */
    public function affecterTransporteur(Livraison $livraison, Transporteur $transporteur): void
    {
        $livraison->assignerTransporteur($transporteur);
        $this->livraisonRepository->save($livraison);
    }
}
