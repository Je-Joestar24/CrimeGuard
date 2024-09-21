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

        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_type')->nullable()->constrained('incident-types');
            $table->dateTime('time_of_incident')->nullable();
            $table->string('status')->default('report')->nullable();
            $table->foreignId('incident_narrative')->nullable()->constrained('incident-narative');
            $table->date('date_reported')->nullable();
            $table->softDeletes('archived_at')->nullable();
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->timestamps();
        });


        Schema::create('incident-victims', function (Blueprint $table) {
            $table->foreignId('incident')->constrained('incidents');
            $table->foreignId('victim')->constrained('victims');
            $table->primary(['incident', 'victim']);
            $table->timestamps();
        });


        Schema::create('incident-suspects', function (Blueprint $table) {
            $table->foreignId('incident')->constrained('incidents');
            $table->foreignId('suspect')->constrained('suspects');
            $table->primary(['incident', 'suspect']);
            $table->timestamps();
        });


        Schema::create('incident-reporting-persons', function (Blueprint $table) {
            $table->foreignId('incident')->constrained('incidents');
            $table->foreignId('reporting_person')->constrained('reporting-persons');
            $table->timestamps();
            $table->primary(['incident', 'reporting_person']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident');
    }
};
