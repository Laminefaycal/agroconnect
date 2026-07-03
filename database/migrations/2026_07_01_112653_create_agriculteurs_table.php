<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agriculteurs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nom_exploitation');
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
