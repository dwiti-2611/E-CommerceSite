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
        Schema::create('cities', function (Blueprint $table) {
            $table->id('CityID'); // AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('StateID');
            $table->string('name');
            $table->timestamps(); // Adds 'CreatedAt' and 'UpdatedAt' columns

            // Foreign key constraint
            $table->foreign('StateID')->references('StateID')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
