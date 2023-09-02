<?php

use App\Models\Article;
use App\Models\Caracteristique;
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
        Schema::create('art_carac', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(Caracteristique::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('art_carac');
    }
};
