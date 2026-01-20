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
        Schema::create('groupe5_label_tache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tache_id')->constrained('groupe5_taches')->onDelete('cascade');
            $table->foreignId('label_id')->constrained('groupe5_labels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe5_label_tache');
    }
};
