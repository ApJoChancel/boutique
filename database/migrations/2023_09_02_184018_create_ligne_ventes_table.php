<?php

use App\Models\Categorie;
use App\Models\Vente;
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
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Categorie::class)->constrained();
            $table->foreignIdFor(Vente::class)->constrained();
            $table->string('carac_ids')->nullable();
            $table->string('carac_texte')->nullable();
            $table->string('qte')->nullable();
            $table->string('prix')->nullable();
            $table->string('reduction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_ventes');
    }
};
