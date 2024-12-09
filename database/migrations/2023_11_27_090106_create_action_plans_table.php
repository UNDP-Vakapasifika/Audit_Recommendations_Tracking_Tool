<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionPlansTable extends Migration
{
    public function up()
    {
        Schema::create('action_plans', function (Blueprint $table) {
            $table->id();
            $table->string('country_office');
            $table->date('date_of_audit');
            $table->string('head_of_audited_entity');
            $table->string('audited_entity_focal_point');
            $table->string('audit_team_lead');
            $table->text('audit_recommendations');
            $table->string('classfication');
            $table->text('audit_report_title');
            $table->text('action_plan');
            $table->string('current_implementation_status');
            $table->date('target_completion_date');
            $table->string('responsible_person');
            $table->string('created_person');
            $table->string('supervised')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('action_plans');
    }
}


