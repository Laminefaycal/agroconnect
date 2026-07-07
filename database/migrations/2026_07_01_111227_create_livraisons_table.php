<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('commande_id')->foreignUuid()->references('id')->on('commandes')->onDelete('cascade');
            $table->uuid('transporteur_id')->foreignUuid()->references('id')->on('transporteurs')->onDelete('set nul');
            $table->dateTime('date_prise_en_charge')->nullable();
            $table->dateTime('date_livraison_effective')->nullable();
            $table->string('statut');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
