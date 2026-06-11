<?php

namespace App\Domain\Commande;

enum ModelLivraison: string
{
    case TRANSPORTEUR = 'TRANSPORTEUR';
    case AGRICULTEUR = 'AGRICULTEUR';
}