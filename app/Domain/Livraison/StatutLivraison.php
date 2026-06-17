<?php

namespace App\Domain\Livraison;

/**
 * Enum StatutLivraison
 *
 * Centralise les différents états possibles d'un colis ou d'une course logistique
 * sur la plateforme AgroConnect au Gabon.
 */
enum StatutLivraison: string
{
    case PROPOSEE = 'PROPOSEE';
    /**
     * @var string Un transporteur a accepté la course et lui a été officiellement assigné.
     */
    case ASSIGNEE = 'ASSIGNEE';

    /**
     * @var string Le transporteur a récupéré la marchandise auprès de l'agriculteur.
     */
    case PRISE_EN_CHARGE = 'PRISE_EN_CHARGE';

    /**
     * @var string Le colis est actuellement en cours de transport vers le point de livraison.
     */
    case EN_ROUTE = 'EN_ROUTE';

    /**
     * @var string La marchandise a été remise en mains propres au consommateur final.
     */
    case LIVREE = 'LIVREE';

    /**
     * @var string Un incident est survenu durant le trajet (panne, retard majeur, route bloquée, etc.).
     */
    case PROBLEME = 'PROBLEME';
}
