<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agriculteurs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('produit_id')->foreignUuid()->references('id')->on('produits')->onDelete('cascade');
            $table->string('nom_exploitation');
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->string('localisation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agriculteurs');
    }
};
