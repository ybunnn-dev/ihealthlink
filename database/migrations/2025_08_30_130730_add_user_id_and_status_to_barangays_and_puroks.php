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
        // Add status column to barangays
        Schema::table('barangays', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('user_id');
        });

        // Add user_id and status to puroks
        Schema::table('puroks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('name');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback for barangays
        Schema::table('barangays', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Rollback for puroks
        Schema::table('puroks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};
