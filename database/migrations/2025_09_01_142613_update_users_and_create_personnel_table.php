<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify users table
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'profile_photo_path')) {
                $table->dropColumn('profile_photo_path');
            }

            $table->string('firstName')->after('id');
            $table->string('lastName')->after('firstName');
            $table->string('middleName')->nullable()->after('lastName');
            $table->string('suffix')->nullable()->after('middleName');

            $table->date('birthdate')->nullable()->after('role_id');
            $table->string('contact_no')->nullable()->after('birthdate');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('contact_no');
        });

        // Create personnel table
        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('brgy_id')->constrained('barangays')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop personnel table
        Schema::dropIfExists('personnel');

        // Rollback users table changes
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'firstName',
                'lastName',
                'middleName',
                'suffix',
                'birthdate',
                'contact_no',
                'status'
            ]);

            $table->string('name')->nullable();
            $table->string('profile_photo_path')->nullable();
        });
    }
};
