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
        Schema::create('groupe6_lecons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('groupe6_cours')->onDelete('cascade');
            $table->string('titre');
            $table->text('contenu');
            $table->string('video_url')->nullable();
            $table->integer('ordre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe6_lecons');
    }
};
