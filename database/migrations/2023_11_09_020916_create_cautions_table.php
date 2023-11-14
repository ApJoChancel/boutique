<?php

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
        Schema::create('cautions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('caution');
            $table->date('date_limite');
            $table->date('date_retour')->nullable();
            $table->unsignedTinyInteger('niveau_degradation')->nullable();
            $table->boolean('est_finalisee')->default(false);
            $table->boolean('est_remboursee')->default(false);
            $table->date('date_remboursee')->nullable();
            $table->unsignedInteger('penalite_date')->nullable();
            $table->unsignedInteger('penalite_degradation')->nullable();
            $table->foreignIdFor(Vente::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cautions');
    }
};
