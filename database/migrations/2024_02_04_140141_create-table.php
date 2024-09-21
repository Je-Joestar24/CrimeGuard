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
        Schema::create('citizen-credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('valid_id')->nullable();
            $table->date('date_request')->default(today());
            $table->date('accepted_date')->nullable();
            $table->softDeletes('archived_at')->nullable();
            $table->foreignId('edited_by')->nullable()->constrained('users');
            $table->foreignId('rejected_by')->nullable()->constrained('users');
            $table->foreignId('accepted_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen-credentials');
    }
};
