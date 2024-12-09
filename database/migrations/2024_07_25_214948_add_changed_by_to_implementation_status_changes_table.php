<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangedByToImplementationStatusChangesTable extends Migration
{
    public function up()
    {
        Schema::table('implementation_status_changes', function (Blueprint $table) {
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('implementation_status_changes', function (Blueprint $table) {
            $table->dropForeign(['changed_by']);
            $table->dropColumn('changed_by');
        });
    }
}
