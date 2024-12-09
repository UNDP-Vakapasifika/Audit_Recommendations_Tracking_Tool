<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration
{
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('report_numbers')->unique();
            $table->string('report_title');
            $table->string('audit_type');
            $table->date('publication_date');
            $table->string('page_par_reference')->nullable();
            $table->text('recommendation');
            $table->string('client');
            $table->string('sector')->nullable();
            $table->text('key_issues')->nullable();
            $table->string('acceptance_status')->nullable();
            $table->string('implementation_status')->nullable();
            $table->string('recurence')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->date('actual_expected_imp_date')->nullable();
            $table->string('sai_confirmation')->nullable();
            $table->string('responsible_entity')->nullable();
            $table->string('summary_of_response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
}

