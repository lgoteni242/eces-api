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
        Schema::create('groupe2_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('groupe2_users')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('groupe2_classes')->onDelete('cascade');
            $table->date('date');
            $table->enum('statut', ['present', 'absent', 'retarde', 'excusé'])->default('present');
            $table->text('commentaire')->nullable();
            $table->timestamps();
            
            // Un étudiant ne peut avoir qu'une seule présence par jour dans une classe
            $table->unique(['etudiant_id', 'classe_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe2_presences');
    }
};
