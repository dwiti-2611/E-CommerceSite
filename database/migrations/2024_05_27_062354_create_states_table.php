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
        Schema::create('states', function (Blueprint $table) {
            $table->id('StateID'); // AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('CountryID');
            $table->string('name');
            $table->timestamps(); // Adds 'CreatedAt' and 'UpdatedAt' columns

            // Foreign key constraint
            $table->foreign('CountryID')->references('CountryID')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
