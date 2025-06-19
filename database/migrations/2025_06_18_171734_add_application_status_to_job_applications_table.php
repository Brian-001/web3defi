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
        Schema::table('job_applications', function (Blueprint $table) {
            //
            $table->enum('application_status', [
                'submitted', 'under_review', 'shortlisted', 'interview_scheduled',
                'assessment_pending', 'offer_extended', 'offer_accepted', 'offer_declined',
                'rejected', 'onhold', 'withdrawn'
            ])->default('submitted')->after('resume_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            //
            $table->dropColumn('application_status');
        });
    }
};
