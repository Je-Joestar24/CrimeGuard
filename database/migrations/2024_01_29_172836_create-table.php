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
        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('qualifier')->nullable();
            $table->string('nickname')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('age')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->unsignedBigInteger('current_address_id')->nullable();
            $table->unsignedBigInteger('other_address_id')->nullable();
            $table->string('highest_educ_attainment')->nullable();
            $table->string('occupation')->nullable();
            $table->string('id_card_presented')->nullable();
            $table->string('email')->nullable();
            $table->string('fb_account')->nullable();
            $table->softDeletes('archived_at');
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->foreign('current_address_id')->references('id')->on('addresses');
            $table->foreign('other_address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('victims');
    }
};
