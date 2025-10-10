<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('family_residence_histories', function (Blueprint $table) {
            // Add is_indigent if missing
            if (!Schema::hasColumn('family_residence_histories', 'is_indigent')) {
                $table->boolean('is_indigent')->default(false)->after('purok_id');
            }

            // Add is_4ps if missing
            if (!Schema::hasColumn('family_residence_histories', 'is_4ps')) {
                $table->boolean('is_4ps')->default(false)->after('is_indigent');
            }

            // Add status if missing
            if (!Schema::hasColumn('family_residence_histories', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_4ps');
            }
        });
    }

    public function down(): void
    {
        Schema::table('family_residence_histories', function (Blueprint $table) {
            if (Schema::hasColumn('family_residence_histories', 'is_indigent')) {
                $table->dropColumn('is_indigent');
            }
            if (Schema::hasColumn('family_residence_histories', 'is_4ps')) {
                $table->dropColumn('is_4ps');
            }
            if (Schema::hasColumn('family_residence_histories', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
