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
        Schema::create('user_plays', function (Blueprint $table) {
            
            $table -> string('gameid');
            $table -> foreign('gameid') 
                   -> references('gameid') 
                   -> on('games')
                   -> onUpdate('cascade')
                   -> onDelete('cascade');

            $table->bigInteger('userid')->unsigned();
            $table -> foreign('userid') 
                   -> references('id') 
                   -> on('users')
                   -> onUpdate('cascade')
                   -> onDelete('cascade');
            
            $table -> string('symbol');
            $table -> string('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plays');
    }
};
