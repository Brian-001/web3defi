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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('listing_title');
            $table->text('company_description')->nullable();
            $table->text('job_description');
            $table->text('job_roles');
            $table->text('additional_info')->nullable();
            $table->string('tags');
            $table->string('location');
            $table->string('salary');
            $table->string('job_type');
            $table->string('listing_logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
