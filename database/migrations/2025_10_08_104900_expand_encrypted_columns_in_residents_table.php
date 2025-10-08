<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->text('firstName')->change();
            $table->text('lastName')->change();
            $table->text('middleName')->nullable()->change();
            $table->text('contact_no')->nullable()->change();
            $table->text('pwd_id')->nullable()->change();
            $table->text('emergencyContactNo')->nullable()->change();
            $table->text('birthdate')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->string('firstName', 50)->change();
            $table->string('lastName', 50)->change();
            $table->string('middleName', 50)->nullable()->change();
            $table->string('contact_no', 15)->nullable()->change();
            $table->string('pwd_id', 50)->nullable()->change();
            $table->string('emergencyContactNo', 15)->nullable()->change();
            $table->string('birthdate', 50)->nullable()->change();
        });
    }
};
