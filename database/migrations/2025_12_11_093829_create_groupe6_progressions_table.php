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
        Schema::create('groupe6_progressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained('groupe6_users')->onDelete('cascade');
            $table->foreignId('lecon_id')->constrained('groupe6_lecons')->onDelete('cascade');
            $table->boolean('termine')->default(false);
            $table->timestamps();
            $table->unique(['etudiant_id', 'lecon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe6_progressions');
    }
};
