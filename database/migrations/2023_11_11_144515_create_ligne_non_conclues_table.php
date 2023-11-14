<?php

use App\Models\Categorie;
use App\Models\NonConclue;
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
        Schema::create('ligne_non_conclues', function (Blueprint $table) {
            $table->id();
            $table->string('option_ids_presents')->nullable();
            $table->string('carac_texte_presents')->nullable();
            $table->string('option_ids_manquants')->nullable();
            $table->string('carac_texte_manquants')->nullable();
            $table->boolean('differee')->nullable();
            $table->unsignedInteger('prix')->nullable();
            $table->unsignedInteger('prix_voulu')->nullable();
            $table->foreignIdFor(NonConclue::class)->constrained();
            $table->foreignIdFor(Categorie::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_non_conclues');
    }
};
