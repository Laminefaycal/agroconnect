<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transporteurs', function (Blueprint $table) {
            $table->string('id')->primary(); // Clé primaire string
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('type_vehicule')->nullable(); // ex: Camion, Moto, Pick-up
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporteurs');
    }
};
