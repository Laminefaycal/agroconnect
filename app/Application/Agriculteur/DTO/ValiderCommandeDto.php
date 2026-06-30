<?php

namespace App\Application\Agriculteur\DTO;

use App\Domain\Commande\ModeLivraison;

/**
 * Class ValiderCommandeDto
 * * Objet de transfert de données (DTO) pour la validation d'une commande par un agriculteur.
 */
class ValiderCommandeDto
{
    /**
     * @var string L'identifiant unique de la commande à valider.
     */
    public string $commandeId;

    /**
     * @var bool Indique si le produit commandé est disponible en stock ou non.
     */
    public bool $estDisponible;

    /**
     * @var string Le mode de livraison choisi (ex: ModeLivraison de votre diagramme).
     */
    public ModeLivraison $modeLivraison;

    /**
     * @var string|null L'identifiant unique du transporteur assigné (optionnel).
     */
    public ?string $transporteurId;

    /**
     * ValiderCommandeDto constructor.
     */
    public function __construct(
        string $commandeId,
        bool $estDisponible,
        ModeLivraison $modeLivraison,
        ?string $transporteurId = null
    ) {
        $this->commandeId = $commandeId;
        $this->estDisponible = $estDisponible;
        $this->modeLivraison = $modeLivraison;
        $this->transporteurId = $transporteurId;
    }
}
