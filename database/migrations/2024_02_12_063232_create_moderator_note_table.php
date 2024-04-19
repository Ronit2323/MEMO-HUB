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
        Schema::create('moderator_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderator_id')->constrained();
            $table->foreignId('note_id')->constrained();
            $table->text('review')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moderator_note');
    }
};
