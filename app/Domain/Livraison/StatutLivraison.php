<?php

namespace App\Domain\Livraison;

enum StatutLivraison: string
{
    case ASSIGNEE = 'ASSIGNEE';
    case PRISE_EN_CHARGE = 'PRISE_EN_CHARGE';
    case EN_ROUTE = 'EN_ROUTE';
    case LIVREE = 'LIVREE';
    case PROBLEME = 'PROBLEME';
}