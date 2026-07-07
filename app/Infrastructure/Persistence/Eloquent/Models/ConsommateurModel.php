<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsommateurModel extends Model
{
    protected $table = 'consommateurs';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nom',
        'telephone',
        'adresse',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Un consommateur peut passer plusieurs commandes
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(CommandeModel::class);
    }
}
