<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('consommateur_id')->foreignUuid()->references('id')->on('consommateurs')->onDelete('cascade');
            $table->uuid('ligne_id')->foreignUuid()->references('id')->on('lignes')->onDelete('cascade');
            $table->uuid('livraison_id')->foreignUuid()->references('id')->on('livraisons')->onDelete('cascade');
            $table->dateTime('date_commande');
            $table->string('statut');
            $table->string('mode_livraison');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
