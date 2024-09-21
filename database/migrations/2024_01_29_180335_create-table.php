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
        Schema::create('incident-categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->softDeletes('archived_at');
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('incident-sub-types', function (Blueprint $table) {
            $table->id();
            $table->string('sub_type');
            $table->softDeletes('archived_at');
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->timestamps();
        });


        Schema::create('administering-officers', function (Blueprint $table) {
            $table->id();
            $table->string('officer_name');
            $table->string('signature')->nullable(); // Assuming signature can be nullable
            $table->timestamps();
            $table->unsignedBigInteger('officer_id')->nullable();

            $table->foreign('officer_id')->references('id')->on('users');
        });

        Schema::create('chief-of-office', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('officer_id')->nullable();

            $table->foreign('officer_id')->references('id')->on('users');
        });

        Schema::create('investigator', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('officer_id')->nullable();

            $table->foreign('officer_id')->references('id')->on('users');
        });

        Schema::create('police-station', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('telephone')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('officer_id')->nullable();

            $table->foreign('officer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident-categories');
        Schema::dropIfExists('incident-sub-type');
        Schema::dropIfExists('administering-officers');
        Schema::dropIfExists('chief-of-office');
        Schema::dropIfExists('investigator');
        Schema::dropIfExists('police-station');
    }
};
