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
        Schema::create('groupe10_conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('groupe10_employes')->onDelete('cascade');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('raison')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe10_conges');
    }
};
