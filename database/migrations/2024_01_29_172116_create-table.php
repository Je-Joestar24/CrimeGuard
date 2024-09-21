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
        Schema::create('suspects', function (Blueprint $table) {
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
            $table->unsignedBigInteger('work_address_id')->nullable();
            $table->string('relation_to_victim')->nullable();
            $table->string('fb_account')->nullable();
            $table->string('email')->nullable();
            $table->string('pnp_rank')->nullable();
            $table->string('unit_assignment')->nullable();
            $table->string('group_affiliation')->nullable();
            $table->boolean('has_previous_record')->default(false);
            $table->text('previous_records_details')->nullable();
            $table->string('status')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('built')->nullable();
            $table->string('eyes_color')->nullable();
            $table->string('eyes_description')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('hair_description')->nullable();
            $table->string('under_influence_of')->nullable();
            $table->softDeletes('archived_at');
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');            
            $table->timestamps();

            $table->foreign('current_address_id')->references('id')->on('addresses');
            $table->foreign('other_address_id')->references('id')->on('addresses');
            $table->foreign('work_address_id')->references('id')->on('addresses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspects');
    }
};
