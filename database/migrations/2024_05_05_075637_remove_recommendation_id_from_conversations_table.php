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
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['recommendation_id']);
            $table->dropColumn('recommendation_id');
            $table->foreignId('final_report_id')->after('id')->constrained('final_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropForeign(['final_report_id']);
            $table->foreignId('recommendation_id')->nullable()->constrained('recommendations')->onDelete('cascade');
        });
    }
};
