<?php

namespace App\Application\Transporteur\DTO;

use App\Domain\Livraison\StatutLivraison;
use InvalidArgumentException;

class MiseAJourStatutDto
{
    private string $livraisonId;

    private string $statut; // On attend une string, on la convertira en enum

    public function __construct(string $livraisonId, string $statut)
    {
        $this->livraisonId = $livraisonId;
        $this->statut = $statut;
    }

    public function getLivraisonId(): string
    {
        return $this->livraisonId;
    }

    /**
     * Convertit la string en enum StatutLivraison
     *
     * @throws InvalidArgumentException si la valeur n'est pas valide
     */
    public function getStatutEnum(): StatutLivraison
    {
        try {
            return StatutLivraison::from($this->statut); // si l'enum supporte from()
        } catch (\ValueError $e) {
            throw new InvalidArgumentException('Statut invalide : '.$this->statut);
        }
    }
}
