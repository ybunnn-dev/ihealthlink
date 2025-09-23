<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_manuals', function (Blueprint $table) {
            $table->id(); // PK1

            // FK to users (strict, not nullable)
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();

            // FK to modules
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();

            $table->string('question');
            $table->string('category');
            $table->text('content');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_manuals');
    }
};
