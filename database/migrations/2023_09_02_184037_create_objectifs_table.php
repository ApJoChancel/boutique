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
        Schema::create('objectifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('montant');
            $table->unsignedTinyInteger('mois');
            $table->unsignedSmallInteger('annee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectifs');
    }
};
