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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('file');
            $table->string('summary');
            $table->string('tags')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected','under-review'])->default('pending');
            $table->unsignedBigInteger('moderator_id')->nullable(); 
            $table->timestamps();
    
            $table->foreign('moderator_id')->references('id')->on('moderators')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
