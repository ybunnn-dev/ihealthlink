<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('families', function (Blueprint $table) {
            if (!Schema::hasColumn('families', 'household_id')) {
                $table->foreignId('household_id')
                    ->after('id')
                    ->constrained('households')
                    ->onDelete('cascade');
            }

            if (!Schema::hasColumn('families', 'head_id')) {
                $table->foreignId('head_id')
                    ->nullable()
                    ->after('household_id')
                    ->constrained('residents')
                    ->onDelete('set null');
            }

            if (!Schema::hasColumn('families', 'is_indigent')) {
                $table->boolean('is_indigent')->default(false)->after('head_id');
            }

            if (!Schema::hasColumn('families', 'is_4ps')) {
                $table->boolean('is_4ps')->default(false)->after('is_indigent');
            }

            if (!Schema::hasColumn('families', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('is_4ps');
            }
        });
    }

    public function down(): void
    {
        Schema::table('families', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropForeign(['head_id']);
            $table->dropColumn([
                'household_id',
                'head_id',
                'is_indigent',
                'is_4ps',
                'status'
            ]);
        });
    }
};
