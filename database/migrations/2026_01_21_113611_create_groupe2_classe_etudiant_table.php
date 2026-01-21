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
        Schema::create('groupe2_classe_etudiant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('groupe2_classes')->onDelete('cascade');
            $table->foreignId('etudiant_id')->constrained('groupe2_users')->onDelete('cascade');
            $table->timestamps();
            
            // Un étudiant ne peut être dans une classe qu'une seule fois
            $table->unique(['classe_id', 'etudiant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe2_classe_etudiant');
    }
};
