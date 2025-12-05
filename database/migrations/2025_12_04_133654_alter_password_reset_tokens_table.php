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
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropPrimary(['email']);
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->id()->first();
            $table->integer('user_id')->after('id');
            $table->string('email')->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'id')) {
                $table->dropColumn('id');
            }
        });
        if (Schema::hasColumn('password_reset_tokens', 'user_id')) {
            $table->dropColumn('user_id');
        }

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->primary('email');
        });
    }
};


