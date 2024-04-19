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
        Schema::table('notifications', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);

            // Remove the user_id column
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Since dropping the foreign key and column in the 'up' method,
        // we need to recreate them in the 'down' method if we want to reverse this migration.
        Schema::table('notifications', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
        });
    }
};
