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
        Schema::table('final_reports', function (Blueprint $table) {
            $table->foreignId('mainstream_categories_id')->nullable()->constrained('mainstream_categories')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('lead_bodies')->onDelete('set null');
            $table->foreignId('client_type_id')->nullable()->constrained('client_types')->onDelete('set null');
            $table->foreignId('sai_responsible_person_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('head_of_audited_entity_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('audited_entity_focal_point_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('audit_team_lead_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('mainstream_categories_id');
            $table->dropConstrainedForeignId('client_id');
            $table->dropConstrainedForeignId('client_type_id');
            $table->dropConstrainedForeignId('sai_responsible_person_id');
            $table->dropConstrainedForeignId('head_of_audited_entity_id');
            $table->dropConstrainedForeignId('audited_entity_focal_point_id');
            $table->dropConstrainedForeignId('audit_team_lead_id');
        });
    }
};
