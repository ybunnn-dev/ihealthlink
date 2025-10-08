<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Expand suffix length to 50 characters
            $table->string('suffix', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Revert to the original length (likely 10 or similar)
            $table->string('suffix', 10)->nullable()->change();
        });
    }
};
