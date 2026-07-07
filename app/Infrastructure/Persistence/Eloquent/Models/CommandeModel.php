<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use App\Domain\Commande\ModeLivraison;
use App\Domain\Commande\StatutCommande;
use App\Domain\Livraison\StatutLivraison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use InvalidArgumentException;

class CommandeModel extends Model
{
    protected $table = 'commandes';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'consommateur_id',
        'date_commande',
        'statut',
        'mode_livraison',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function consommateur(): BelongsTo
    {
        return $this->belongsTo(ConsommateurModel::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommandeModel::class);
    }

    public function livraison(): HasOne
    {
        return $this->hasOne(LivraisonModel::class);
    }

    /**
     * Valider la commande
     */
    public function valider(): void
    {
        if ($this->statut !== StatutCommande::EN_ATTENTE_VALIDATION) {
            throw new InvalidArgumentException('Seule une commande en attente peut être validée.');
        }

        $this->statut = StatutCommande::VALIDEE;
        $this->save();
    }

    /**
     * Choisir le mode de livraison
     */
    public function choisirModeLivraison(ModeLivraison $mode): void
    {
        $this->mode_livraison = $mode;
        $this->save();
    }

    /**
     * Assigner un transporteur à la livraison de cette commande
     */
    public function assignerTransporteur(string $transporteurId): void
    {
        if ($this->mode_livraison === ModeLivraison::AGRICULTEUR) {
            throw new InvalidArgumentException('Impossible d’assigner un transporteur en mode livraison par agriculteur.');
        }

        // On récupère la livraison existante ou on en crée une nouvelle liée
        $livraison = $this->livraison;

        if ($livraison === null) {
            $livraison = new LivraisonModel;
            $livraison->id = uniqid();
            $livraison->commande_id = $this->id;
            $livraison->statut = StatutLivraison::ASSIGNEE;
        }

        $livraison->transporteur_id = $transporteurId;
        $livraison->save();

        // La commande passe à l'état en livraison
        $this->statut = StatutCommande::EN_LIVRAISON;
        $this->save();
    }
}
