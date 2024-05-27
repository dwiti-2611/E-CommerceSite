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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('AddressID'); // AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('UserID'); // INT NOT NULL
            $table->string('Street', 255)->nullable();
            $table->string('City', 100)->nullable();
            $table->string('State', 100)->nullable();
            $table->string('Country', 100)->nullable();
            $table->string('ZipCode', 20)->nullable();
            $table->enum('AddressType', ['Shipping', 'Billing']); // ENUM
            $table->timestamps(); // Adds 'CreatedAt' and 'UpdatedAt' columns

            // Foreign key constraint
            $table->foreign('UserID')->references('UserID')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
