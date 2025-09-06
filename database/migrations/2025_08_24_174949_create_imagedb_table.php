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
        Schema::create('imagedb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_retail')->nullable();
            $table->unsignedBigInteger('id_salon')->nullable();
            $table->unsignedBigInteger('id_restaurant')->nullable();
            $table->string('image_path', 255);
            // Foreign key constraints
            $table->foreign('id_retail')->references('id')->on('inventoryretail')->onDelete('cascade');
            $table->foreign('id_salon')->references('id')->on('inventorysalon')->onDelete('cascade');
            $table->foreign('id_restaurant')->references('id')->on('inventoryrestaurant')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('imagedb', function (Blueprint $table) {
            $table->dropForeign(['id_products']);
            $table->dropForeign(['id_salon']);
            $table->dropForeign(['id_restaurant']);
        });
        Schema::dropIfExists('imagedb');
    }
};
