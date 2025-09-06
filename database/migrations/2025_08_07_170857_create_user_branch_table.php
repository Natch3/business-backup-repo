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
        Schema::create('user_branch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_branch')->nullable();
            $table->foreign('id_branch')->references('id')->on('branches')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_branch', function (Blueprint $table) {
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_branch']);
        });
        Schema::dropIfExists('user_branch');
    }
};
