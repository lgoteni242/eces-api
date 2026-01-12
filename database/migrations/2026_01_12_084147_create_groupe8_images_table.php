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
        // Supprimer la table si elle existe partiellement (pour éviter l'erreur d'index en double)
        if (Schema::hasTable('groupe8_images')) {
            Schema::dropIfExists('groupe8_images');
        }
        
        Schema::create('groupe8_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('path');
            $table->string('filename');
            $table->nullableMorphs('imageable'); // imageable_type et imageable_id (polymorphic) - crée automatiquement l'index
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe8_images');
    }
};
