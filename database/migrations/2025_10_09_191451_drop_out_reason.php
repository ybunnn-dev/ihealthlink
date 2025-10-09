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
        Schema::table('family_planning_data', function (Blueprint $table) {
            $table->string('client_type')->nullable()->after('id');
            $table->string('source')->nullable()->after('client_type');
            $table->string('previous_method')->nullable()->after('source');
            $table->date('dropout_date')->nullable()->after('previous_method');
            $table->text('dropout_reason')->nullable()->after('dropout_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_planning_data', function (Blueprint $table) {
            $table->dropColumn([
                'client_type',
                'source',
                'previous_method',
                'dropout_date',
                'dropout_reason',
            ]);
        });
    }
};
