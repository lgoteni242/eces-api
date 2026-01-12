<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groupe3_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('path');
            $table->string('filename');
            $table->foreignId('salle_id')->constrained('groupe3_salles')->onDelete('cascade');
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index('salle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe3_images');
    }
};
