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
        //
        Schema::table('incidents', function (Blueprint $table) {
            //
            $table->string('village')->nullable();
            $table->string('barangay')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        //
    }
};
