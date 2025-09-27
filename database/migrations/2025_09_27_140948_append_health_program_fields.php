<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppendHealthProgramFields extends Migration
{
    public function up(): void
    {
        Schema::table('health_programs', function (Blueprint $table) {
            $table->unsignedInteger('age_min')->nullable()->after('status');
            $table->unsignedInteger('age_max')->nullable()->after('age_min');
            $table->string('category')->nullable()->after('age_max');
        });
    }

    public function down(): void
    {
        Schema::table('health_programs', function (Blueprint $table) {
            $table->dropColumn(['age_min', 'age_max', 'category']);
        });
    }
}
