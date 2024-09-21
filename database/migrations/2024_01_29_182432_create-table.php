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
        Schema::create('incident-narative', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incident_type_id')->nullable();
            $table->unsignedBigInteger('addresses_id');
            $table->date('date_of_incident');
            $table->text('details');
            $table->unsignedBigInteger('reporting_person_id')->nullable();
            $table->unsignedBigInteger('administering_officer_id')->nullable();
            $table->unsignedBigInteger('assisting_officer_id')->nullable();
            $table->string('blotter_entry_nr')->nullable();
            $table->timestamps();

            $table->foreign('incident_type_id')->references('id')->on('incident-types')->onDelete('set null');
            $table->foreign('addresses_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('reporting_person_id')->references('id')->on('reporting-persons')->onDelete('set null');
            $table->foreign('administering_officer_id')->references('id')->on('administering-officers')->onDelete('set null');
            $table->foreign('assisting_officer_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident-narative');
    }
};
