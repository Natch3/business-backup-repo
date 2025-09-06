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
        Schema::create('inventoryretail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_branch')->nullable();
            $table->string('product_id', 15)->unique();
            
            $table->char('ret', 64)->unique()->nullable();
            $table->string('product_name', 200)->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_category')->nullable();
            $table->integer('product_stock_quantity')->default(0);
            $table->decimal('product_price', 10, 2);
            $table->string('product_sku', 100)->nullable();        // optional SKU
            $table->string('product_unit', 50)->nullable();

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
        Schema::table('inventoryretail', function (Blueprint $table) {
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_branch']);
            $table->dropForeign(['product_id ']);
            $table->dropUnique(['ret']);
        });
        Schema::dropIfExists('inventoryretail');
    }
};
