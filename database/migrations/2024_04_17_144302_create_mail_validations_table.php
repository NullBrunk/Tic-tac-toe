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
        Schema::create('mail_validations', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('userid');
            $table -> foreign('userid') -> references('id') -> on('users');
            $table -> text("checksum");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_validations');
    }
};
