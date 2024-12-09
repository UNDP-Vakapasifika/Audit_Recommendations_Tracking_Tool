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
        Schema::table('action_plans', function (Blueprint $table) {
            $table->dropColumn('audit_recommendations');
            $table->dropColumn('audit_report_title');
            $table->foreignId('recommendation_id')->nullable()->constrained();
            $table->foreignId('category_type_id')->nullable()->constrained('mainstream_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_plans', function (Blueprint $table) {
            $table->text('audit_recommendations')->nullable();
            $table->text('audit_report_title')->nullable();
            $table->dropConstrainedForeignId('recommendation_id');
            $table->dropConstrainedForeignId('category_type_id');
        });
    }
};

