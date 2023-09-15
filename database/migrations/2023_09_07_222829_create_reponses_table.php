<?php

use App\Models\Choix;
use App\Models\Question;
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
        Schema::create('reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vente::class)->constrained();
            $table->foreignIdFor(Question::class)->constrained();
            $table->foreignIdFor(Choix::class)->constrained(table: 'choix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reponses');
    }
};
