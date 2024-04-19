<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('likes_dislikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('note_id')->constrained();
            $table->boolean('liked'); // true for like, false for dislike
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('likes_dislikes');
    }
};
