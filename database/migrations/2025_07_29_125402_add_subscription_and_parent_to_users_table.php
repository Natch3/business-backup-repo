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
        $table->dateTime('subscription_expires_at')->nullable()->after('password');
        $table->unsignedBigInteger('parent_id')->nullable()->after('subscription_expires_at');

        $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['parent_id']);
        $table->dropColumn(['subscription_expires_at', 'parent_id']);
    });
}
};
