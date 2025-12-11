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
        Schema::create('groupe2_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('groupe2_users')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('groupe2_matieres')->onDelete('cascade');
            $table->foreignId('professeur_id')->constrained('groupe2_users')->onDelete('cascade');
            $table->decimal('note', 4, 2);
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe2_notes');
    }
};
