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
        Schema::create('inventorysalon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_branch')->nullable();
            $table->string('service_id', 15)->unique();

            $table->char('sal', 64)->unique()->nullable();
            $table->string('service_name', 200)->nullable();
            $table->text('service_description')->nullable();
            $table->string('service_category')->nullable();
            $table->decimal('service_price', 10, 2);
            $table->integer('service_duration')->nullable();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_branch')->references('id')->on('branches')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::table('inventorysalon', function (Blueprint $table) {
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_branch']);
            $table->dropForeign(['service_id ']);
            $table->dropUnique(['sal']);
        });

        Schema::dropIfExists('inventorysalon');
    }
};
