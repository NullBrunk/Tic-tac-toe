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
        Schema::table('user_joins', function (Blueprint $table) {
            $table->index('game_id');
            $table->index('user_id');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->index('id');
            $table->index('winner');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('id');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_joins', function (Blueprint $table) {
            $table->dropIndex('game_id');
            $table->dropIndex('user_id');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('winner');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('id');
            $table->dropIndex('email');
        });
    }
};
