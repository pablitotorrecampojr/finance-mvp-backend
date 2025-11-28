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
        Schema::create('otp_vertifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('one_time_password');
            $table->string('status');
            $table->datetime('expiration_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_vertifications');
    }
};
