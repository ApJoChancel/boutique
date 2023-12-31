<?php

use App\Models\Boutique;
use App\Models\Role;
use App\Models\Type;
use App\Models\Zone;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('password');
            $table->foreignIdFor(Role::class)->nullable()->constrained();
            $table->foreignIdFor(Boutique::class)->nullable()->constrained();
            $table->foreignIdFor(Type::class)->constrained();
            $table->foreignIdFor(Zone::class)->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
