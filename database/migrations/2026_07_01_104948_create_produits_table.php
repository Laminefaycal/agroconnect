<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('agriculteur_id')->foreignUuid()->references('id')->on('agriculteurs')->onDelete('cascade');
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
