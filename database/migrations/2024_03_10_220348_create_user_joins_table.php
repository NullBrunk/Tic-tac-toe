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
        Schema::create('user_joins', function (Blueprint $table) {
            $table -> unsignedBigInteger('player');
            $table -> foreign('player') 
                   -> references('id') 
                   -> on('users')
                   -> onUpdate('cascade')
                   -> onDelete('cascade');

            $table -> string('gameid');
            $table -> foreign('gameid') 
                    -> references('gameid') 
                    -> on('games')
                    -> onUpdate('cascade')
                    -> onDelete('cascade');

            $table -> string("symbol");

         

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_joins');
    }
};
