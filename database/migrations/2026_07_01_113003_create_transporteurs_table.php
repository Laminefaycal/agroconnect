<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transporteurs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('livraisons_id')->foreignUuid()->references('id')->on('livraisons')->onDelete('set null');
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('type_vehicule')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transporteurs');
    }
};
