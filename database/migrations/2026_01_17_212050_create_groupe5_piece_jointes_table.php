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
        Schema::create('groupe5_piece_jointes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('groupe5_taches')->onDelete('cascade');
            $table->string('nom_original'); // ex: cahier_des_charges.pdf
            $table->string('chemin');       // ex: projets/fichiers/unique_name.pdf
            $table->string('type_mime');    // ex: application/pdf
            $table->unsignedBigInteger('taille')->nullable(); // Size in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe5_piece_jointes');
    }
};
