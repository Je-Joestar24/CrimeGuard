<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incident-types', function (Blueprint $table) {
            $table->id();
            $table->string('incident_name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_type_id');
            $table->softDeletes('archived_at');
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->foreignId('added_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('incident-categories');
            $table->foreign('sub_type_id')->references('id')->on('incident-sub-types');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incident-types');
    }
};
