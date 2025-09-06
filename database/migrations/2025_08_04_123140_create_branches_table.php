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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name');
            $table->string('business_type');
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('contact_number')->nullable();
            $table->string('branch_logo')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('id_users')->nullable();
            $table->string('status')->default('Pending');
            // Foreign key constraints
            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                Schema::table('branches',function(Blueprint $table){
        $table->dropForeign(['id_users']);
        });
        Schema::dropIfExists('branches');
    }
};
