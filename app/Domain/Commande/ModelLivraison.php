<?php

namespace App\Domain\Commande;

/**
 * Enum ModelLivraison
 *
 * Définit les différents modes de livraison disponibles pour une commande sur AgroConnect.
 * Cet enum backé par une chaîne de caractères (string) garantit la cohérence des règles métiers
 * liées à la logistique d'acheminement au Gabon.
 *
 * @package App\Domain\Commande
 */
enum ModelLivraison: string
{
    /**
     * @var string Prise en charge et acheminement des produits par un transporteur tiers ou professionnel.
     */
    case TRANSPORTEUR = 'TRANSPORTEUR';

    /**
     * @var string Récupération directe des produits par le consommateur ou gestion en propre par l'agriculteur.
     */
    case AGRICULTEUR = 'AGRICULTEUR';
}