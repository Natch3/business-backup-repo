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
        Schema::create('purchase_retail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users');
            $table->decimal('subtotal', 10, 2);
            $table->boolean('bag_selected')->default(false);
            $table->decimal('bag_price', 10, 2)->default(5.00);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('cash_given', 10, 2);
            $table->decimal('change_amount', 10, 2);
            $table->timestamps();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_retail', function (Blueprint $table) {
            $table->dropForeign(['id_users']);

        });
        Schema::dropIfExists('purchase_retail');
    }
};
