<?php

namespace App\Domain\Commande;

/**
 * Enum StatutCommande
 *
 * Représente les différents états possibles d'une commande tout au long de son cycle de vie.
 * Cet enum sécurise la logique métier en interdisant l'utilisation de statuts non conformes.
 */
enum StatutCommande: string
{
    /**
     * @var string La commande a été créée par le consommateur et attend d'être validée.
     */
    case EN_ATTENTE_VALIDATION = 'EN_ATTENTE_VALIDATION';

    /**
     * @var string La commande a été validée et confirmée (le paiement ou l'accord est effectif).
     */
    case VALIDEE = 'VALIDEE';

    /**
     * @var string La commande a été prise en charge et elle est en cours d'acheminement / livraison.
     */
    case EN_LIVRAISON = 'EN_LIVRAISON';

    /**
     * @var string Les produits ont été remis avec succès au consommateur final.
     */
    case LIVREE = 'LIVREE';

    /**
     * @var string La commande est clôturée de façon définitive (archivée et finalisée).
     */
    case TERMINEE = 'TERMINEE';
}
