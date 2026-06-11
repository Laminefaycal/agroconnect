<?php

namespace App\Domain\Commande;

enum StatutCommande: string
{
    case EN_ATTENTE_VALIDATION = 'EN_ATTENTE_VALIDATION';
    case VALIDEE = 'VALIDEE';
    case EN_LIVRAISON = 'EN_LIVRAISON';
    case LIVREE = 'LIVREE';
    case TERMINEE = 'TERMINEE';
}