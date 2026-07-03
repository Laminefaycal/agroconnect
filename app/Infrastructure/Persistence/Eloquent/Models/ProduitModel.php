<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'agriculteur_id',
        'nom',
        'description',
        'prix_unitaire',
    ];

    protected $casts = [
        'id' => 'string',
        'prix_unitaire' => 'decimal:2',
    ];


    public function agriculteur(): BelongsTo
    {
        return $this->belongsTo(AgriculteurModel::class, 'agriculteur_id', 'id');
    }


    public function estDisponible(int $quantite): bool
    {
        return $this->stock >= $quantite;
    }

    public function decrementerStock(int $quantite): void
    {
        if ($this->estDisponible($quantite)) {
            $this->stock -= $quantite;
            $this->save();
        }
    }
}
