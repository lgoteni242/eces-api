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
        Schema::create('groupe6_quiz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('groupe6_cours')->onDelete('cascade');
            $table->text('question');
            $table->json('reponses');
            $table->integer('reponse_correcte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe6_quiz');
    }
};
