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
        Schema::create('faculty_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            // Add any additional columns if needed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faculty_subject');
    }
};
