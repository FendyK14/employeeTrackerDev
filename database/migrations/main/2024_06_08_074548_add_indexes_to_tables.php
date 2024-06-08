<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->index('companyId');
            $table->index('positionId');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index('employeeId');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->index('employeeId');
            $table->index('projectId');
            $table->index('subActivityId');
        });

        Schema::table('performances', function (Blueprint $table) {
            $table->index('employeeId');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index('groupId');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('employeeId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex(['companyId']);
            $table->dropIndex(['positionId']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['employeeId']);
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex(['employeeId']);
            $table->dropIndex(['projectId']);
            $table->dropIndex(['subActivityId']);
        });

        Schema::table('performances', function (Blueprint $table) {
            $table->dropIndex(['employeeId']);
        });

        Schema::table('projects', function (Blueprint $table) {
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['employeeId']);
        });
    }
};
