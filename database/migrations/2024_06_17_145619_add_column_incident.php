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
            $table->unsignedBigInteger('copy_for')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            // Drop the foreign key constraint first if you added it
            // $table->dropForeign(['copy_for_id']);
            
            $table->dropColumn('copy_for');
        });
    }
};
