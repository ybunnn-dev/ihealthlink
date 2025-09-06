<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_icons', function (Blueprint $table) {
            $table->string('viewbox')->nullable()->after('path'); // adjust column name if needed
        });
    }

    public function down(): void
    {
        Schema::table('activity_icons', function (Blueprint $table) {
            $table->dropColumn('viewbox');
        });
    }
};
