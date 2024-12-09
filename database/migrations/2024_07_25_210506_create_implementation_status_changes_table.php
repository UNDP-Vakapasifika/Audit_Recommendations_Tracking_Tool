<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('implementation_status_changes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('final_report_id');
            $table->string('from_status');
            $table->string('to_status');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('evidence')->nullable();
            $table->string('impact')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('final_report_id')->references('id')->on('final_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('implementation_status_changes');
    }
};
