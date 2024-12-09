<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalReportsTable extends Migration
{
    public function up()
    {
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->string('country_office');
            $table->string('audit_report_title');
            $table->string('audit_type');
            $table->date('date_of_audit');
            $table->date('publication_date');
            $table->string('page_par_reference');
            $table->text('audit_recommendations');
            $table->string('classification');
            $table->text('key_issues');
            $table->string('acceptance_status');
            $table->string('current_implementation_status');
            $table->string('reason_not_implemented')->nullable();
            $table->date('follow_up_date');
            $table->date('target_completion_date')->nullable();
            $table->string('recurrence')->nullable();
            $table->text('action_plan');
            $table->text('summary_of_response');
            $table->string('responsible_person_email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_reports');
    }
}
