<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Type::class)->constrained();
            $table->foreignIdFor(Zone::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
            $table->dropForeign(['zone_id']);
            $table->dropColumn('zone_id');
        });
    }
};
