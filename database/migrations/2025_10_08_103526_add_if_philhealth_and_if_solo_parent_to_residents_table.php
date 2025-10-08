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
        Schema::table('residents', function (Blueprint $table) {
            // Add new columns after specific fields if desired
            $table->boolean('if_philhealth')->default(false)->after('is_indigenous');
            $table->boolean('if_solo_parent')->default(false)->after('if_philhealth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn(['if_philhealth', 'if_solo_parent']);
        });
    }
};
