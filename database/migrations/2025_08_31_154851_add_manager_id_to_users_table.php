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
        Schema::table('users', function (Blueprint $table) {
            // Add manager_id column (nullable so top-level users/owners can exist without a manager)
            $table->unsignedBigInteger('managers_id')->nullable()->after('id');

            // Add foreign key constraint referencing users.id
            $table->foreign('managers_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // if a manager is deleted, their staff are also deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key first, then column
            $table->dropForeign(['managers_id']);
            $table->dropColumn('managers_id');
        });
    }
};
