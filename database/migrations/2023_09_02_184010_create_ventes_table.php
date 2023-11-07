<?php

use App\Models\Boutique;
use App\Models\Client;
use App\Models\User;
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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('montant')->default(0);
            $table->date('date');
            $table->string('type'); //Vente | Location
            $table->string('motif')->nullable();
            $table->string('comment')->nullable();
            $table->foreignIdFor(Client::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Boutique::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
