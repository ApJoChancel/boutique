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
        Schema::create('parametres', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('delais_vente')->default(30);
            $table->unsignedSmallInteger('delais_location')->default(45);
            $table->time('heure')->default('2024-01-01 08:00:00');
            $table->time('delais_retard')->default('2024-01-01 00:10:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametres');
    }
};
