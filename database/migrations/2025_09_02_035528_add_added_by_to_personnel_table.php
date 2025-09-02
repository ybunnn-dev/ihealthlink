<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->foreignId('added_by')
                  ->default(1)
                  ->constrained('users')
                  ->after('brgy_id')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropForeign(['added_by']); // drop the foreign key first
            $table->dropColumn('added_by');
        });
    }
};
