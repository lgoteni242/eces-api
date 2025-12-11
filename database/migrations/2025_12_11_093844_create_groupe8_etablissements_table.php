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
        Schema::create('groupe8_etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->enum('type', ['restaurant', 'hotel']);
            $table->string('adresse');
            $table->string('telephone')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe8_etablissements');
    }
};
