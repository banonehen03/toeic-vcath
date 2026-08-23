<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('citizen_id', 20)->nullable()->after('email'); // CCCD
            $table->string('phone', 15)->nullable()->after('citizen_id'); // SĐT
            $table->string('verification_code', 6)->nullable()->after('remember_token');
            $table->timestamp('code_expires_at')->nullable()->after('verification_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'citizen_id', 'phone', 'verification_code', 'code_expires_at']);
        });
    }
};