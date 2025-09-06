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
        Schema::create('inventoryrestaurant', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users');
            $table->unsignedBigInteger('id_branch')->nullable();
                        $table->string('menu_id', 15)->unique();

            $table->char('res', 64)->unique()->nullable();
            $table->string('menu_name', 200)->nullable();
            $table->text('menu_description')->nullable();
            $table->string('menu_category')->nullable();
            $table->decimal('menu_price', 10, 2);

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
        Schema::table('inventoryrestaurant', function (Blueprint $table) {
            $table->dropForeign(['id_users']);
            $table->dropForeign(['id_branch']);
            $table->dropForeign(['menu_id ']);
            $table->dropUnique(['res']);
        });
        Schema::dropIfExists('inventoryrestaurant');
    }
};
