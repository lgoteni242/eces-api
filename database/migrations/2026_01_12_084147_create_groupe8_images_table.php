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
        Schema::create('groupe8_images', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('path');
            $table->string('filename');
            $table->nullableMorphs('imageable'); // imageable_type et imageable_id (polymorphic)
            $table->timestamps();

            // Index pour améliorer les performances
            $table->index(['imageable_type', 'imageable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupe8_images');
    }
};
