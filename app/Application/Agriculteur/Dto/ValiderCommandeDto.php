<?php

namespace App\Application\Agriculteur\DTO;

/**
 * Class ValiderCommandeDto
 * * Objet de transfert de données (DTO) pour la validation d'une commande par un agriculteur.
 */
class ValiderCommandeDto
{
    /**
     * @var int L'identifiant unique de la commande à valider.
     */
    public int $commandeId;

    /**
     * @var bool Indique si le produit commandé est disponible en stock ou non.
     */
    public bool $estDisponible;

    /**
     * @var string Le mode de livraison choisi (ex: ModeLivraison de votre diagramme).
     */
    public string $modeLivraison;

    /**
     * @var int|null L'identifiant unique du transporteur assigné (optionnel).
     */
    public ?int $transporteurId;

    /**
     * ValiderCommandeDto constructor.
     */
    public function __construct(
        int $commandeId,
        bool $estDisponible,
        string $modeLivraison,
        ?int $transporteurId = null
    ) {
        $this->commandeId = $commandeId;
        $this->estDisponible = $estDisponible;
        $this->modeLivraison = $modeLivraison;
        $this->transporteurId = $transporteurId;
    }
}
