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
        Schema::create('groupe2_classes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('niveau')->nullable(); // Ex: 6ème, 5ème, Terminale, etc.
            $table->string('annee_scolaire')->nullable(); // Ex: 2024-2025
            $table->foreignId('professeur_principal_id')->nullable()->constrained('groupe2_users')->onDelete('set null');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe2_classes');
    }
};
