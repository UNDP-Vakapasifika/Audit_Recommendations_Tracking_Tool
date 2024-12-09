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
        Schema::table('notes', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['final_report_id']);
            
            // Add the new foreign key constraint with cascading delete
            $table->foreign('final_report_id')->references('id')->on('final_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['final_report_id']);
            
            // Recreate the foreign key constraint without cascading delete
            $table->foreign('final_report_id')->references('id')->on('final_reports');
        });
    }
};
