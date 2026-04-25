<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('patient')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->boolean('is_active')->default(true)->after('phone');
            $table->softDeletes();
        });
    }

    public function down(): void
{
    Schema::dropIfExists('sessions');
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('users');
}
};