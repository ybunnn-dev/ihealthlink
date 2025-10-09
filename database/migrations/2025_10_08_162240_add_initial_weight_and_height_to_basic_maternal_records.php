<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('basic_maternal_records', function (Blueprint $table) {
            $table->decimal('initial_weight', 5, 2)->nullable()->after('para');
            $table->decimal('initial_height', 5, 2)->nullable()->after('initial_weight');
        });
    }

    public function down(): void
    {
        Schema::table('basic_maternal_records', function (Blueprint $table) {
            $table->dropColumn(['initial_weight', 'initial_height']);
        });
    }
};
